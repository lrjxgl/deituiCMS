<?
/*--------------------------------
����:		�й�������PHP HTTP�ӿ� ���Ͷ���
�޸�����:	2009-04-08
˵��:		http://http.c123.com/tx/?uid=�û��˺�&pwd=MD5λ32����&mobile=����&content=����
״̬:
	100 ���ͳɹ�
	101 ��֤ʧ��
	102 ���Ų���
	103 ����ʧ��
	104 �Ƿ��ַ�
	105 ���ݹ���
	106 �������
	107 Ƶ�ʹ���
	108 �������ݿ�
	109 �˺Ŷ���
	110 ��ֹƵ����������
	111 ϵͳ�ݶ�����
	112 ���벻��ȷ
	120 ϵͳ����
--------------------------------*/

/*
$uid = '9999';		//�û��˺�
$pwd = '9999';		//����
$mobile	 = '13912341234,13312341234,13512341234,02122334444';	//����
$content = '�й�������PHP HTTP�ӿ�';		//����
//��ʱ����
$res = sendSMS($uid,$pwd,$mobile,$content);
echo $res;
$time = '2010-05-27 12:11';
$res = sendSMS($uid,$pwd,$mobile,$content,$time);
echo $res;
*/
class sendSMS
{
	public function __construct(){
		
	}
	
	function send($uid,$pwd,$mobile,$content,$time='',$mid='')
	{
		$http = 'http://http.c123.com/tx/';
		$data = array
			(
			'uid'=>$uid,					//�û��˺�
			'pwd'=>strtolower(md5($pwd)),	//MD5λ32����
			'mobile'=>$mobile,				//����
			'content'=>$content,			//����
			'time'=>$time,		//��ʱ����
			'mid'=>$mid						//����չ��
			);
		$re= postSMS($http,$data);			//POST��ʽ�ύ
		if( trim($re) == '100' )
		{
			return "���ͳɹ�!";
		}
		else 
		{
			return "����ʧ��! ״̬��".$re;
		}
	}
	
	function postSMS($url,$data='')
	{
		$row = parse_url($url);
		$host = $row['host'];
		$port = $row['port'] ? $row['port']:80;
		$file = $row['path'];
		while (list($k,$v) = each($data)) 
		{
			$post .= rawurlencode($k)."=".rawurlencode($v)."&";	//תURL��׼��
		}
		$post = substr( $post , 0 , -1 );
		$len = strlen($post);
		$fp = @fsockopen( $host ,$port, $errno, $errstr, 10);
		if (!$fp) {
			return "$errstr ($errno)\n";
		} else {
			$receive = '';
			$out = "POST $file HTTP/1.1\r\n";
			$out .= "Host: $host\r\n";
			$out .= "Content-type: application/x-www-form-urlencoded\r\n";
			$out .= "Connection: Close\r\n";
			$out .= "Content-Length: $len\r\n\r\n";
			$out .= $post;		
			fwrite($fp, $out);
			while (!feof($fp)) {
				$receive .= fgets($fp, 128);
			}
			fclose($fp);
			$receive = explode("\r\n\r\n",$receive);
			unset($receive[0]);
			return implode("",$receive);
		}
	}

}
?>