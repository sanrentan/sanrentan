<?php
App::uses('CakeEmail', 'Network/Email');

//記事の日別アクセス数
class ArticleLogDailyCountShell extends AppShell {

    public $uses = array('Race', 'Article', 'ArticleLog', 'ArticleDailyCount');

    public function getOptionParser() {
        $parser = parent::getOptionParser();

        $parser->addOption(
            'day', array(
                'help' => 'day [yyyy-mm-dd]',
                'default' => date('Y-m-d', strtotime('-1 day', time())),
            )
        );

        return $parser;
    }

    public function main() {
    	$msg = "start shell";
    	$this->__log($msg);

        $target_date = $this->params['day'];
        $start = $this->params['day'].' 00:00:00';
        $end   = $this->params['day'].' 23:59:59';

        //集計する
        $this->ArticleLog->virtualFields['cnt'] = 0;//これを追加
        $options = array(
            'fields' => array('article_id','count(*) as ArticleLog__cnt'),
            'conditions' => array(
                'created between ? and ?' => array($start, $end),
            ),
            'group' => array('article_id'),
            'order' => 'article_id desc',
        );
        $logs = $this->ArticleLog->find('all',$options);
        if(empty($logs)){
            $this->__log("finish ok!");
            return;
        }

        $total = 0;
        foreach($logs as $key=>&$data){
            //Articleを取得
            $article = $this->Article->findById($data['ArticleLog']['article_id']);
            $data['ArticleLog']['name'] = $article['Article']['title'];

            //全体合計
            $total += $data['ArticleLog']['cnt'];

            //dailyのログテーブルへの保存(すでにあればupdate)
            $dailyCount = array();
            $options = array(
                'conditions' => array(
                    'article_id' => $data['ArticleLog']['article_id'],
                    'target_date' => $target_date,
                )
            );
            $dailyCount = $this->ArticleDailyCount->find('first',$options);
            if(empty($dailyCount)){
                $this->ArticleDailyCount->create();
            }
            $dailyCount['ArticleDailyCount']['article_id'] = $data['ArticleLog']['article_id'];
            $dailyCount['ArticleDailyCount']['cnt'] = $data['ArticleLog']['cnt'];
            $dailyCount['ArticleDailyCount']['target_date'] = $target_date;
            $this->ArticleDailyCount->save($dailyCount);


            //Articleのアクセス数を更新
            $article['Article']['cnt'] += $data['ArticleLog']['cnt'];
            $this->Article->save($article);
        }

        //メール送信
        $email = new CakeEmail('smtp'); 
        $email->to('info@sanrentan-box.com');
        $email->subject( '['.$target_date.'] 記事閲覧数');
        $email->emailFormat('text');
        $email->template('article_daily_log');
        $email->viewVars(compact('logs', 'target_date', 'total'));
        $email->send();

    	$this->__log("finish ok!");

    }

}