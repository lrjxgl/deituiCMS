<?php
$jssdk = new JSSDK($wx['appid'], $wx['appkey']);
$signPackage = $jssdk->GetSignPackage();	
?>
<script src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
		var wxshare_title="厦门得推网络科技有限公司，专注于公众号小程序开发，咨询电话：15985840591";
		var wxshare_link=document.location.href;
		var wxshare_imgUrl=location.protocol+"//www.shuxianglai.com/static/images/logo.png";
		var wxshare_desc="厦门得推网络科技有限公司，专注于公众号小程序开发，咨询电话：15985840591";
			$(function(){
				 
				wx.config({
					 
					appId: '<?php echo $signPackage["appId"];?>',
				    timestamp: <?php echo $signPackage["timestamp"];?>,
				    nonceStr: '<?php echo $signPackage["nonceStr"];?>',
				    signature: '<?php echo $signPackage["signature"];?>',
				    jsApiList: [
				      "checkJsApi",
				        "onMenuShareTimeline",
				        "onMenuShareAppMessage",
				        "onMenuShareQQ",
				        "onMenuShareWeibo",
				        "onMenuShareQZone",
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
				    wx.onMenuShareTimeline({
					    title: wxshare_title, // 分享标题
					    link: wxshare_link, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
					    imgUrl: wxshare_imgUrl, // 分享图标
					    success: function () { 
					        // 用户确认分享后执行的回调函数
					    },
					    cancel: function () { 
					        // 用户取消分享后执行的回调函数
					    }
					});
					//分享给朋友
					wx.onMenuShareAppMessage({
						title: wxshare_title, // 分享标题
					    link: wxshare_link, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
					    imgUrl: wxshare_imgUrl, // 分享图标					     
					    desc: wxshare_desc, // 分享描述
					     
					    type: '', // 分享类型,music、video或link，不填默认为link
					    dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
					    success: function () { 
					        // 用户确认分享后执行的回调函数
					    },
					    cancel: function () { 
					        // 用户取消分享后执行的回调函数
					    }
					});
					//分享到QQ
					wx.onMenuShareQQ({
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
					//分享到腾讯
					wx.onMenuShareQZone({
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
</script>