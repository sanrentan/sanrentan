<?php

//RSSを取得してキャッシュする
class RssGetShell extends AppShell {

    public function getOptionParser() {
        $parser = parent::getOptionParser();

        $parser->addOption(
            'race_id', array(
                'help' => 'race_id',
                'default' => null,
            )
        );

        return $parser;
    }

    public function main() {

    	$this->__log("start shell");

        $rss_array = array(
            'keiba_news' => 'http://keiba.jp/rss/news.xml',//RSS 競馬ニュース
            'expectRss' => 'http://keiba.jp/rss/column.xml',//競馬コラム

            'umasoku' => 'http://umasoku.doorblog.jp/index.rdf',//まとめサイト
            'keibakyodai' => 'http://keibakyoudai.com/feed.xml',//まとめサイト
            'keibayosou' => 'http://blog.livedoor.jp/win_keibayosou/index.rdf',//まとめサイト
            'umachannel' => 'http://bspear.com/feed',//まとめサイト
        );

        foreach ($rss_array as $key=>$data){
            $this->__log('start:'.$key.":".$data);
            $this->__getRss($key,$data);
            $this->__log('end:'.$key);
        }

    	$this->__log("finish ok!");

    }

    private function __getRss($key,$url){

        $fileData = file_get_contents($url);
        if(!empty($fileData)){
            Cache::write($key,$fileData,"rss");
        }else{
            echo "error";
            return null;
        }
    }



}