<?php
App::uses('CakeEmail', 'Network/Email');

//metimes用の移行プログラム
class MetimesShell extends AppShell {

    public $uses = array('Page', 'PagePart', 'TagUsage', 'Tag','WpPostmeta','WpPost','WpTermRelationship', 'WpTerm', 'WpTermTaxonomy');

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

        //DBの初期化
        $this->Page->useDbConfig = "metimes";
        $this->PagePart->useDbConfig = "metimes";
        $this->TagUsage->useDbConfig = "metimes";
        $this->Tag->useDbConfig = "metimes";
        $this->WpPostmeta->useDbConfig = "metimes";
        $this->WpPostmeta->useTable = "wp_postmeta";
        $this->WpPost->useDbConfig = "metimes";
        $this->WpTermRelationship->useDbConfig = "metimes";
        $this->WpTerm->useDbConfig = "metimes";
        $this->WpTermTaxonomy->useDbConfig = "metimes";
        $this->WpTermTaxonomy->useTable = "wp_term_taxonomy";

        $category = array(
            'home'    => '2',
            'recipe'  => '3',
            'gourmet' => '4',
            'outing'  => '5',
            'beauty'  => '6',
            'today'   => '7',
        );

        $userList = array(
            '2' => 2,
            '6' => 3,
            '16' => 4,
            '19' => 5,
            '22' => 6,
            '24' => 7,
            '25' => 8,
            '28' => 9,
            '29' => 10,
            '33' => 11,
            '39' => 12,
            '40' => 13,
            '42' => 14,
            '50' => 15,
            '53' => 16,
            '55' => 17,
            '61' => 18,
            '75' => 19,
            '76' => 20,
            '77' => 21,
            '79' => 22,
            '81' => 23,
            '93' => 24,
            '96' => 25,
            '97' => 26,
            '102' => 27,
         );


        $target_date = $this->params['day'];


        //pageからデータを取得
        $options = array(
            'conditions' => array(
                'status' => "public",
                'NOT' => array(
                    'review_passed_at' => null,
                )
            ),

            'order' => 'id asc'
        );
        $pageData = $this->Page->find('all',$options);

        $mode=2;

        //postを登録（contents以外)
        if($mode=="1"){

            foreach($pageData as $key=>$data){
                $postData = array();
                $postData['id'] = $data['Page']['id'];

                //カテゴリー
                $categoryData = array();
                $categoryData['object_id'] = $data['Page']['id'];
                $categoryData['term_taxonomy_id'] = $category[$data['Page']['root']];
                $categoryData['term_order'] = 0;

                $postData['post_author'] = $userList[$data['Page']['user_id']];
                $postData['post_date'] = $data['Page']['review_passed_at'];
                $postData['post_date_gmt'] = $data['Page']['review_passed_at'];
                $postData['post_content'] = '';//とりあえず空で
                $postData['post_title'] = $data['Page']['title'];
                $postData['post_excerpt'] = '';
                $postData['post_status'] = 'publish';
                $postData['comment_status'] = 'closed';
                $postData['ping_status'] = 'open';
                $postData['post_password'] = '';
                $postData['post_name'] = '';
                $postData['to_ping'] = '';
                $postData['pinged'] = '';
                $postData['post_modified'] = $data['Page']['review_passed_at'];
                $postData['post_modified_gmt'] = $data['Page']['review_passed_at'];
                $postData['post_content_filtered'] = '';
                $postData['post_parent'] = 0;
                $postData['guid'] = '';
                $postData['menu_order'] = 0;
                $postData['post_type'] = 'post';
                $postData['post_mime_type'] = '';
                $postData['comment_count'] = '';

                //description
                $metaData = array();
                $metaData['post_id'] = $data['Page']['id'];
                $metaData['meta_key'] = "bzb_meta_description";
                $metaData['meta_value'] = $data['Page']['meta_description'];

                //保存処理
                if(!$this->WpPost->save($postData)){
                    echo "save error 1";exit;
                }

                //idをupdate
                $sql = "update wp_posts set id = ". $data['Page']['id'] ." where id = 0 limit 1";
                $this->WpPost->query($sql);

                $this->WpPostmeta->create();
                if(!$this->WpPostmeta->save($metaData)){
                    echo "save error 2";exit;
                }
                if(!$this->WpTermRelationship->save($categoryData)){
                    echo "save error 3";exit;
                }

                $this->__log("ok:".$data['Page']['id']);
            }

        //contentを登録
        }elseif($mode==2){
            foreach($pageData as $key=>$data){
                $this->__log('id:'.$data['Page']['id']);

                //記事を取得
                $postData = $this->WpPost->findById($data['Page']['id']);

                $options = array(
                    "conditions" => array(
                        "reference_of" => "pages",
                        "reference_id" => (int)$postData["WpPost"]["ID"]
                    ),
                    "order" => "priority asc"
                );
                $oldDatas = $this->PagePart->find('all',$options);
                if(empty($oldDatas)){
                    echo "null.id=".$data['Page']['id'];exit;
                }
                $message = null;

                foreach($oldDatas as $key2=>$oldData){
                    switch ($oldData['PagePart']['part_type']) {
                        case 'image':
                            $message .= '<div class="images"><img id="'.$oldData['PagePart']['id'].'" src="/wp-content/uploads/images/'.$oldData['PagePart']['image_url'].'" class="single-image"></div>';
                            break;
                        
                        case 'text':
                            $message .= $oldData['PagePart']['content_formatted'];
                            break;
                        
                        case 'image-text':
                            $message .= '<div class="half-image-block" data-role="local">';
                            $message .= '<div class="half-image-block-img"><img id="'.$oldData['PagePart']['id'].'" src="/wp-content/uploads/images/'.$oldData['PagePart']['image_url'].'" class="single-image" data-raw="'.$oldData['PagePart']['image_url'].'" data-source="local">';

                            if(!empty($oldData['PagePart']['source_url'])){
                                $message .= '<p>出典：'.str_replace("http://", "", $oldData['PagePart']['source_url']).'</p>';
                            }
                            $content = str_replace(array("\r\n", "\r", "\n"), '', $oldData['PagePart']['content']);
                            $message .= '</div><p class="half-text">'.$content.'</p>';
                            $message .= '</div><div style="clear:both;"></div>';
                            break;
                        
                        case 'h2':
                            $message .= '<h2>'.$oldData['PagePart']['content'].'</h2>';
                            break;
                        case 'h3':
                            $message .= '<h3>'.$oldData['PagePart']['content'].'</h3>';
                            break;

                        case 'instagram':
                            $message .= $oldData['PagePart']['content_formatted'];
                            break;

                        case 'tweet':
                            $message .= $oldData['PagePart']['content_formatted'];
                            break;

                        case 'video':
                            $message .= $oldData['PagePart']['content_formatted'];
                            break;

                        case 'link':
                            $message .= '<p class="link-large" data-raw="'.$oldData['PagePart']['content'].'" data-role="'.$oldData['PagePart']['content'].'"><i class="fa fa-external-link-square "></i><a href="'.$oldData['PagePart']['source_url'].'" rel="nofollow" target="_blank">'.$oldData['PagePart']['content'].'</a></p>';
                            break;

                        case 'quote':
                            $message .= '<blockquote data-role="'.$oldData['PagePart']['source_url'].'">'.$oldData['PagePart']['quote'].'</blockquote>';
                            $message .= '<p class="quote-source">引用: <a href="'.$oldData['PagePart']['source_url'].'" rel="nofollow" target="_blank">'.$oldData['PagePart']['source_url'].'</a></p>';
                            break;

                        case 'border':
                            $message .= '<hr>';
                            break;

                        default:
                            echo "type is wrong:";
                            echo $oldData['PagePart']['part_type'];
                            # code...
                            break;
                    }                    
                }

                //$this->WpPost->ID = $data['Page']['id'];
                //$this->WpPost->saveField('content', $message);
                //$postData['WpPost']['content'] = $message;
                //$this->WpPost->save($postData);

                $sql = "update wp_posts set post_content = ? where id = ".$data['Page']['id']." limit 1";
                $this->WpPost->query($sql,array($message));
            }


        //投稿のサムネイルを設定
        }elseif($mode==3){
            exit;

            //postsからデータ取得
            $options = array(
                'conditions' => array(
                    'id >=' => 3015,
                    'id <=' => 3455,
                    'post_type' => 'attachment'
                )
            );
            $postData = $this->WpPost->find('all',$options);
            foreach($postData as $key=>$data){
                //pagesからデータ取得
                $pageData = $this->Page->findById($data['WpPost']['post_parent']);

                //post_metaにデータ追加
                $saveData = array();
                $saveData['post_id'] = $data['WpPost']['ID'];
                $saveData['meta_key'] = '_wp_attached_file';
                $saveData['meta_value'] = 'images/'.$pageData['Page']['thumbnail'];
                $this->WpPostmeta->create();
                $this->WpPostmeta->save($saveData);
            }



            exit;


            //post_metaから取得
            $options = array(
                'conditions' => array(
                    'meta_key' => '_thumbnail_id',
                    'post_id >=' => 3015
                )
            );
            $metaData = $this->WpPostmeta->find('all',$options);
            foreach($metaData as $key => $data){
                //post情報を取得
                $postData = $this->WpPost->findById($data['WpPostmeta']['post_id']);
                $sql = "update wp_postmeta set post_id = ? where meta_id = ? limit 1";
                $this->WpPost->query($sql,array($postData['WpPost']['post_parent'],$data['WpPostmeta']['meta_id']));
            }
            exit;

            foreach($pageData as $key=>$data){
                $this->__log('id:'.$data['Page']['id']);
                $post_id = $data['Page']['id'];

                if($post_id<1016){
                    continue;
                }

                $file_name = $data['Page']['thumbnail'];
                if(empty($file_name)){
                    echo "file name is null :".$data['Page']['id'];exit;
                }
                $file_name = explode('.', $file_name);
                if(count($file_name)!=2){
                    echo "count is wrong :".$data['Page']['id'];exit;
                }
                if($file_name[1]!="jpg" && $file_name[1]!="jpeg" && $file_name[1]!="png" && $file_name[1]!="gif" && $file_name[1]!="JPG"){
                    echo "ext is wrong :".$data['Page']['id'];
                    print_r($data);exit;
                }

                $mine_type = null;
                if($file_name[1]=="jpg"||$file_name[1]=="jpeg"||$file_name[1]=="JPG"){
                    $mine_type = "image/jpeg";
                }elseif($file_name[1]=="gif"){
                    $mine_type = "image/gif";
                }elseif($file_name[1]=="png"){
                    $mine_type = "image/png";
                }else{
                    echo "mime_type is wrong :".$data['Page']['id'];
                    print_r($data);exit;
                }


                //wp_postsに登録
                $postData['post_author'] = 1;
                $postData['post_date'] = $data['Page']['review_passed_at'];
                $postData['post_date_gmt'] = $data['Page']['review_passed_at'];
                $postData['post_content'] = '';//とりあえず空で
                $postData['post_title'] = $file_name[0];//ファイル名
                $postData['post_excerpt'] = '';
                $postData['post_status'] = 'inherit';
                $postData['comment_status'] = 'open';
                $postData['ping_status'] = 'closed';
                $postData['post_password'] = '';
                $postData['post_name'] = $file_name[0];//ファイル名
                $postData['to_ping'] = '';
                $postData['pinged'] = '';
                $postData['post_modified'] = $data['Page']['review_passed_at'];
                $postData['post_modified_gmt'] = $data['Page']['review_passed_at'];
                $postData['post_content_filtered'] = '';
                $postData['post_parent'] = $post_id;
                $postData['guid'] = '';
                $postData['menu_order'] = 0;
                $postData['post_type'] = 'attachment';
                $postData['post_mime_type'] = $mine_type;
                $postData['comment_count'] = '';

                $this->WpPost->create();
                $this->WpPost->save($postData);
 
                //wp_postmetaに登録
                $last_id = $this->WpPost->getLastInsertID();
                $metaData = array();
                $metaData['post_id'] = $data['Page']['id'];
                $metaData['meta_key'] = "_thumbnail_id";
                $metaData['meta_value'] = $last_id;
                $this->WpPostmeta->create();
                $this->WpPostmeta->save($metaData);


            }

            echo "end";
            exit;

        //タグの設定
        }elseif($mode==4){

            $tagData = $this->Tag->find('all');

            foreach($tagData as $key=>$data){
                $this->__log('id:'.$data['Tag']['id']);
                $saveData = array();
                $saveData['name'] = $data['Tag']['name'];
                $saveData['slug'] = urlencode($data['Tag']['name']);
                $saveData['term_group'] = 0;
                $this->WpTerm->create();
                $this->WpTerm->save($saveData);
                $last_id = $this->WpTerm->getLastInsertID();

                //WpTermTaxonomyに保存
                $taxnomyData = array();
                $taxnomyData['term_id'] = $last_id;
                $taxnomyData['taxonomy'] = 'post_tag';
                $taxnomyData['description'] = '';
                $taxnomyData['parent'] = 0;
                $taxnomyData['count'] = $data['Tag']['child_pages'];
                $this->WpTermTaxonomy->create();
                $this->WpTermTaxonomy->save($taxnomyData);
            }
        
        //記事とタグの関連性
        }elseif($mode==5){

            $tagUseData = $this->TagUsage->find('all');
            foreach($tagUseData as $key=>$data){

                //page情報を取得
                $pageData = $this->WpPost->findById($data['TagUsage']['page_id']);
                if(empty($pageData)){
                    continue;
                }

                //Tag情報を取得
                $tagData = $this->Tag->findById($data['TagUsage']['tag_id']);

                //Tag情報からTerm情報を取得
                $options = array(
                    'conditions' => array(
                        'name' => $tagData['Tag']['name']
                    )
                );
                $termData = $this->WpTerm->find('first',$options);
                if(empty($termData)){
                    continue;
                }

                $this->__log('id:'.$data['TagUsage']['id']);

                $saveData = array();
                $saveData['object_id'] = $data['TagUsage']['page_id'];
                $saveData['term_taxonomy_id'] = $termData['WpTerm']['term_id'];
                $this->WpTermRelationship->create();
                $this->WpTermRelationship->save($saveData);
            }

        }


/**

thumbnail
status
notified（使ってない）
user_id
published_at
created_at
updated_at
is_promotion(３つだけyes)
resize_thumbnail
include_list（使ってない）
hide (yes no あるけど何かわからない！）
promoter (is_promotionと同じく３つだけなにかある）
promoter_url （使ってない）
thumbnail_source (使ってない）

view_count
last_appear_at
*/

        



    	$this->__log("finish ok!");

    }

}