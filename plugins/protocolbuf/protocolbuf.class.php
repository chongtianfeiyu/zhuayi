<?php
/**
 * protocolbuf
 *
 * @package default
 * @author zhuayi
 *	$this->load_class('protocolbuf');
 *	$reset = $this->protocolbuf->get_proto('/Users/zhuayi/Downloads/inner_header.proto');
 *	$innerHeader = new InnerHeader();
 *	$innerHeader->set_cmd(100);
 *	$innerHeader->set_subcmd(500);
 *	$reset = $innerHeader->SerializeToString();
 */

include dirname(__FILE__).'/message/pb_message.php';
include dirname(__FILE__).'/parser/pb_parser.php';

class protocolbuf 
{
	public $file_path = 'protocolbuf';

	/**
	 * 构 造 函 数
	 *
	 * @author zhuayi
	 */
	function __construct()
	{
		global $file;

		/* 加载文件操作类 */
		$this->file = & $file;

		$this->PBParser = new PBParser();
	}


	function get_proto($protofile)
	{
		$filename =  basename($protofile);
		$filename = explode('.',$filename);
		$filename = $filename[0].".php";
		$file_content = $this->PBParser->parse($protofile);
		
		$reset = $this->file->write($this->file_path.'/'.$filename,$file_content);

		if ($reset)
		{
			return require ZHUAYI_ROOT.$reset;
		}
		else
		{
			throw new Exception("读取文件出错!", -1);
		}
	}

}

?>
