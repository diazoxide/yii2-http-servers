<?php

namespace diazoxide\yii2hhm\controllers;

use diazoxide\yii2hhm\models\Rules;
use diazoxide\yii2hhm\models\Servers;
use diazoxide\yii2hhm\models\ServersLogs;
use Yii;
use yii\db\Exception;
use yii\web\Controller;
use yii\httpclient\Client;
use MatthiasMullie\Minify;

class HostController extends Controller
{
    /**
     * {@inheritdoc}
     */

    public function behaviors()
    {
        return [
            [
                'class' => 'yii\filters\HttpCache',
                'only' => ['index'],
                'lastModified' => function ($action, $params) {
                    return 0;
                },
                'cacheControlHeader' => "Cache-Control: public, max-age=99999999999999"
            ],
            'pageCache' => [
                'class' => 'yii\filters\PageCache',
                'enabled' => true,
                'only' => ['index'],
                'duration' => 999999999999,
                'variations' => [
                    Yii::$app->request->get('path'),
                    $_SERVER['SERVER_ADDR']
                ]
            ],
        ];
    }

    const RULES_CLEAN = 1;
    const RULES_ONLY_SERVER_CONTENT = 2;
    const RULES_SERVER_MODIFIED_CONTENT = 3;
    const RULES_ONLY_REMOTE_CONTENT = 3;

    /**
     * @param $url
     * @return \yii\httpclient\Response
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\httpclient\Exception
     */
    public function sendHttpRequest($url)
    {
        $url_Parsed = parse_url($url);

        $host = $url_Parsed['host'];
        $path = isset($url_Parsed['path']) ? $url_Parsed['path'] : "";
        $query = isset($url_Parsed['query']) ? $url_Parsed['query'] : "";

        $client = new Client();
        $ip = gethostbyname($host);
        $ipURL = "http://" . $ip . "/" . $path . '?' . $query;

        return $client->createRequest()
            ->setHeaders(['Host: ' . $host, "Location: " . $url])
            ->setFormat(Client::FORMAT_RAW_URLENCODED)
            ->addOptions(
                [
                    'followLocation' => false,
                    'timeout' => 10,
                    'maxRedirects' => 2,
                    CURLOPT_ENCODING => ""

                ])
            ->setMethod('GET')
            ->setUrl($ipURL)
            ->send();
    }


    /**
     * @param Servers $server
     * @param $url
     * @return mixed|\yii\httpclient\Response
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\httpclient\Exception
     */
    public function getHttpRequest($server, $url)
    {
        if ($server->cache && !preg_match("/$server->cache_exceptions/", $url)) {

            $ref = preg_replace('/\?.*/', '', $url);

            $cacheKey = $server->ip . "_cache_" . $ref;
            $cache = Yii::$app->cache;

            // Getting cached data
            $http_response = $cache->get($cacheKey);

            // Cached data not found
            if ($http_response === false) {
                $http_response = $this->sendHttpRequest($url);

                // Start Caching
                $cache = Yii::$app->cache;
                $data = $http_response;
                $cache->set($cacheKey, $data, $server->cache_expire);

            }
        } else {
            $http_response = $this->sendHttpRequest($url);
        }
        return $http_response;
    }


    public function initScripts($server, $string)
    {
        $pattern = "/(?>\[\[code:)\"([^]]+)\"(?>\]\])/m";

        $_this = $this;
        $line = preg_replace_callback(
            $pattern,
            function ($matches) use ($server, $_this) {
                try {
                    return eval($matches[1]);
                } catch (Exception $e) {
                    return "// Code error.";
                }
            },
            $string
        );
        return $line;
    }

    /**
     * @param Servers $server
     * @param $http_response
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function getScripts($server, $http_response)
    {
        $content = "";
        foreach ($server->getScripts()->asArray()->all() as $script) {
            $content_types = preg_split('/\r\n|\r|\n/', $script['content_types']);

            foreach ($content_types as $content_type) {

                if (strpos($http_response->headers['content-type'], $content_type) !== false) {
                    if ($script['append']) {
                        $content .= $this->initScripts($server, $script['script']);
                    } else {
                        $content = $this->initScripts($server, $script['script']) . $content;
                    }
                    break;
                }
            }
        }
        return $content;
    }

    /**
     * @param $server
     * @param $url
     * @param $inHead
     * @param $callback
     * @return string
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\httpclient\Exception
     */
    public function loadScript($server, $url, $inHead = false, $callback = "")
    {
        $internal = $this->getHttpRequest($server, $url)->getContent();
        $result = <<<JS
(function () {
    var t = setTimeout(function(){
        if (typeof(document.querySelectorAll('[src="$url"]')[0]) === 'undefined' || document.querySelectorAll('[src="$url"]')[0] == null){
            var script = document.createElement('script');
            script.type = 'text/javascript';
            script.src = "$url";
            var inHead = $inHead;
            
            if(inHead){ 
                try{
                    document.head.appendChild(script);
                } catch (e) {}
            }
            else{
                try{
                    document.body.appendChild(script);
                } catch (e) {}
            }
            script.onload = function(){
                try{
                    $callback
                } catch (e) {}
            };
            script.onerror = function(){
                try{
                    try{
                        $internal
                    } catch (e) {}
                    try{
                        $callback
                    } catch (e) {}
                } catch (e) {}
            };
            clearInterval(t);
        }
    },50);
    
})();
JS;
        return $result;
    }

    /**
     * @param string $url
     * @param Servers $server
     * @return mixed
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\httpclient\Exception
     */
    public function expandRules($url, $server)
    {
        /** @var yii\web\Response $response */
        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_RAW;

        $pattern = "/(?>\[\[code:)\"(.*)\"(?>\]\])/m";
        $url_parts = parse_url($url);
        $query_parts = [];
        try {
            parse_str($url_parts['query'], $query_parts);
        } catch (\Exception $e) {

        }
        /** @var Servers $server */
        /** @var Rules $rule */
        foreach ($server->getRules()->orderBy(['priority' => SORT_DESC])->all() as $rule) {
            if (preg_match("/$rule->match/", $url)) {
                $response->headers->add("RuleName", $rule->name);
                /** @var Rules $rule */
                if ($rule->redirect) {

                    $to = $rule->to;

                    $last_url = preg_replace_callback(
                        $pattern,
                        function ($matches) use ($url, $url_parts, $query_parts) {
                            try {
                                return eval($matches[1]);
                            } catch (Exception $e) {
                                return "// Code error.";
                            }
                        },
                        $to
                    );

                    return $this->redirect($last_url);


                }

                if ($rule->clean) {
                    return $response;
                }


                if ($rule->remote_content) {
                    $http_response = $this->getHttpRequest($server, $url);
                    if ($http_response->isOk) {
                        $response->content .= $http_response->getContent();
                    } else {
                        $http_response->headers['content-type'] = 'application/javascript';
                    }
                }

                if ($rule->content_type != "") {
                    $response->headers->set("Content-type", $rule->content_type);
                } else {

                    if (isset($http_response)) {
                        $response->headers->set("Content-type", $http_response->headers['content-type']);
                    }

                }

                if ($rule->server_content) {
                    foreach ($server->getScripts()->asArray()->all() as $script) {
                        $content_types = preg_split('/\r\n|\r|\n/', $script['content_types']);

                        foreach ($content_types as $content_type) {

                            if (strpos($response->headers->get('Content-type'), $content_type) !== false) {
                                if ($script['append']) {
                                    $response->content .= $this->initScripts($server, $script['script']);
                                } else {
                                    $response->content = $this->initScripts($server, $script['script']) . $response->content;
                                }
                                break;
                            }
                        }
                    }
                }
                break;
            }
        }
        return $response;
    }


    /**
     * @param string $path
     * @return string
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\httpclient\Exception
     */
    public function actionIndex($path)
    {
        $server = Servers::findOne(['ip' => $_SERVER['SERVER_ADDR']]);
        $url = Yii::$app->request->absoluteUrl;
        $response = $this->expandRules($url, $server);


        if ($server->compress) {
            if (strpos($response->headers['Content-type'], 'javascript') !== false) {
                $compress = new Minify\JS($response->content);
                $response->content = $compress->minify();
            }
        }

        return $response;

//        if ($server->logs) {
//            $logs = new ServersLogs();
//            $logs->server_id = $server->id;
//            $logs->ip_address = Yii::$app->request->userIP;
//            $logs->user_agent = Yii::$app->request->userAgent;
//            $logs->url = $url;
//            $logs->referer = Yii::$app->request->referrer;
//            $logs->status = $http_response->statusCode;
//            $logs->save();
//        }

        //return $response;
    }

}
