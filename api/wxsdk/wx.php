<?php
$jssdk = new JSSDK($wx['appid'], $wx['appkey']);
$signPackage = $jssdk->GetSignPackage();	
?>
<script src="https://res.wx.qq.com/open/js/jweixin-1.6.0.js"></script>
<script>
		var wxshare_title=document.title;
		var wxshare_link=document.location.href;
		var wxshare_imgUrl=location.protocol+"//"+document.domain+"/static/images/logo.400x400.png";
		var wxshare_desc=document.title;
			$(function(){
				 
				wx.config({
					debug:<?=$debug?>, 
					appId: '<?php echo $signPackage["appId"];?>',
				    timestamp: <?php echo $signPackage["timestamp"];?>,
				    nonceStr: '<?php echo $signPackage["nonceStr"];?>',
				    signature: '<?php echo $signPackage["signature"];?>',
				    jsApiList: [
				      "checkJsApi",
				        "updateTimelineShareData",
				        "updateAppMessageShareData",
				        "onMenuShareWeibo",
				        "hideMenuItems",
				        "showMenuItems",
				        "hideAllNonBaseMenuItem",
				        "showAllNonBaseMenuItem",
				        "translateVoice",
				        "startRecord",
				        "stopRecord",
				        "onVoiceRecordEnd",
				        "playVoice",
				        "onVoicePlayEnd",
				        "pauseVoice",
				        "stopVoice",
				        "uploadVoice",
				        "downloadVoice",
				        "chooseImage",
				        "previewImage",
				        "uploadImage",
				        "downloadImage",
				        "getNetworkType",
				        "openLocation",
				        "getLocation",
				        "hideOptionMenu",
				        "showOptionMenu",
				        "closeWindow",
				        "scanQRCode",
				        "chooseWXPay",
				        "openProductSpecificView",
				        "addCard",
				        "chooseCard",
				        "openCard"
				    ]
				});
				
				wx.ready(function () {
				    // 分享到朋友圈
				    wx.updateTimelineShareData({
					    title: wxshare_title, // 分享标题
					    link: wxshare_link, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
					    imgUrl: wxshare_imgUrl, // 分享图标
					    success: function () { 
					        
					    },
					    cancel: function () { 
					        // 用户取消分享后执行的回调函数
					    }
					});
					//分享给朋友
					wx.updateAppMessageShareData({
						title: wxshare_title, // 分享标题
					    link: wxshare_link, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
					    imgUrl: wxshare_imgUrl, // 分享图标					     
					    desc: wxshare_desc, // 分享描述
					    success: function () { 
					        // 用户确认分享后执行的回调函数
					    },
					    cancel: function () { 
					        // 用户取消分享后执行的回调函数
					    }
					});

					//分享到腾讯
					wx.onMenuShareWeibo({
					    title: wxshare_title, // 分享标题
					    link: wxshare_link, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
					    imgUrl: wxshare_imgUrl, // 分享图标					     
					    desc: wxshare_desc, // 分享描述
					    success: function () { 
					       // 用户确认分享后执行的回调函数
					    },
					    cancel: function () { 
					        // 用户取消分享后执行的回调函数
					    }
					});
					
				});
				 
			})
			
			wx.error(function(res){
				skyToast(res);
			})
</script>