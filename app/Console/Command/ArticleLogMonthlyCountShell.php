<?php
App::uses('CakeEmail', 'Network/Email');

//記事の月別アクセス数
class ArticleLogMonthlyCountShell extends AppShell {

    public $uses = array('Race', 'Article', 'ArticleDailyCount', 'ArticleMonthlyCount');

    public function getOptionParser() {
        $parser = parent::getOptionParser();

        $parser->addOption(
            'month', array(
                'help' => 'month [yyyy-mm]',
                'default' => date('Y-m', strtotime('-1 month', time())),
            )
        );

        return $parser;
    }

    public function main() {
    	$msg = "start shell";
    	$this->__log($msg);

        $target_month = $this->params['month'].'-01';
        $start = $this->params['month'].'-01 00:00:00';
        $end   = date('Y-m-t 23:59:59',strtotime($start));

        //集計する
        $this->ArticleDailyCount->virtualFields['sum'] = 0;//これを追加
        $options = array(
            'fields' => array('article_id','sum(cnt) as ArticleDailyCount__sum'),
            'conditions' => array(
                'target_date between ? and ?' => array($start, $end),
            ),
            'group' => array('article_id')
        );
        $logs = $this->ArticleDailyCount->find('all',$options);
        if(empty($logs)){
            $this->__log("finish ok!");
            return;
        }

        $total = 0;
        foreach($logs as $key=>&$data){
            //Articleを取得
            $article = $this->Article->findById($data['ArticleDailyCount']['article_id']);
            $data['ArticleDailyCount']['name'] = $article['Article']['title'];

            //全体合計
            $total += $data['ArticleDailyCount']['sum'];

            //monthlyのログテーブルへの保存(すでにあればupdate)
            $monthlyCount = array();
            $options = array(
                'conditions' => array(
                    'article_id' => $data['ArticleDailyCount']['article_id'],
                    'target_month' => $target_month,
                )
            );
            $monthlyCount = $this->ArticleMonthlyCount->find('first',$options);
            if(empty($monthlyCount)){
                $this->ArticleMonthlyCount->create();
            }
            $monthlyCount['ArticleMonthlyCount']['article_id'] = $data['ArticleDailyCount']['article_id'];
            $monthlyCount['ArticleMonthlyCount']['cnt'] = $data['ArticleDailyCount']['sum'];
            $monthlyCount['ArticleMonthlyCount']['target_month'] = $target_month;
            $this->ArticleMonthlyCount->save($monthlyCount);
        }

        $target_month = $this->params['month'];

        //メール送信
        $email = new CakeEmail('smtp'); 
        $email->to('info@sanrentan-box.com');
        $email->subject( '['.$target_month.'] 月間_記事閲覧数');
        $email->emailFormat('text');
        $email->template('article_monthly_log');
        $email->viewVars(compact('logs', 'target_month', 'total'));
        $email->send();

    	$this->__log("finish ok!");

    }

}