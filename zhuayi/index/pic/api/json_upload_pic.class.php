<?php
/*
 * api_upload_pic.php     Zhuayi 异步上传图片接口
 *
 * @copyright    (C) 2005 - 2010  zhuayi
 * @licenes      http://www.zhuayi.net
 * @lastmodify   2010-10-28
 * @author       zhuayi
 * @QQ			 2179942
 */
class json_upload_pic extends zhuayi
{

	function __construct()
	{
		parent::__construct();
	}

	function run($referer = '')
	{
		$show['args'] = "run=1;".str_replace('&',';',http_build_query($_GET));
	
		if (!empty($referer))
		{
			$reset = $this->upload();

			if ($referer == 'self')
			{
				return $this->self_upload($reset);
			}
			else if ($referer == 'keditor')
			{
				$this->keditor_upload($reset);
				exit;
			}
		}
		
		$show['callbak_url'] = '/api/pic/json_upload_pic/self';

		$this->display($show);
	}

	function upload()
	{
		$this->load_class('image',true);

		if ($_POST['date'] == '-1')
		{
			$date = '';
		}
		else
		{
			$date = date("Y-m-d");
		}
		// GET参数优先 
		if (isset($_GET['dir']))
		{
			$_POST['dir'] = $_GET['dir'];
		}

		/* 缩略图 zomm =  65,200,200:200 */
		if (isset($_POST['zomm']))
		{
			$zomm = explode(',',$_POST['zomm']);
			$filename = array();
		}
		else
		{
			$filename[0]['filename'] = '/'.$_POST['dir'].'/'.$date."/".time();
		}
		

		foreach ($zomm as $key=>$val)
		{
			$val = explode(':',$val);
			$filename[$key]['filename'] = '/'.$_POST['dir'].'/'.implode('_',$val).'/'.$date."/".time();
			$filename[$key]['width'] = $val[0];
			$filename[$key]['height'] = $val[1];
		}
		
		
		$this->image->show($_FILES['imgFile']);

		/* 缩放图片 */
		if (is_array($filename))
		{
			foreach ($filename as $val)
			{
				$reset = $this->image->zomm($val['width'],$val['height'])->save($val['filename']);
			}
			
		}
		else
		{

			$reset = $this->image->save($filename);
		}
		
		$reset['msg'] = json_encode($reset['msg']);

		return $reset;
	}

	/* 自身上传返回结果 */
	function self_upload($reset)
	{
		throw new Exception($reset['msg'], $reset['status']);
	}

	/* 来源编辑器 */
	function keditor_upload($reset)
	{
		if ($reset['status'] == 1)
		{
			$reset['status'] = 0;
		}
		else
		{
			$reset['status'] = 1;
		}
		$results['error'] = $reset['status'];
		$results['message'] = $reset['msg'];
		$results['url'] = json_decode($reset['msg'],true);
		$results['url'] = $results['url']['src'];
		echo json_encode($results);
	}
}