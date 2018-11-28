<?php
$config = array (	
		//应用ID,您的APPID。
		'app_id' => "2 ",

		//商户私钥，您的原始格式RSA私钥
		'merchant_private_key' => "MIIEp uusjjDme5FsxoT8iZ7Z7/Nm6+OIijRDxLTDZHAWRMCspUqccO9+kRB+Fa2bYC4upcLaY+y1sPmmM1R9KQC9PA/30MV9r4v6PCQxZwxZ2WsPsPwQMIQuwzOHbflvoAE3mWi+utPMw2wPGw7Xhc/cKFHKFt0hccApyDWTViDbs2Sd0mstRmVqkq5Vqq6f5yKPI3+dUMOh9n59nfSuCzAMoFMoPf360h10t/6YQaQtQ4tTAz9BcjmFQp40jmA0PV9gpX4SZUP1I/0OPFZo8OrFZXHs0BAE9mNW1FrftC6Z1z6DAZczgH2PRLZRbvVIwIDAQABAoIBAHr2mGRl0NLg/VTpmF0gv2m0YxvIA1beBDokxLzUBtCZlIrf1ShRxm9avMtbyXBLNsgPw+gJ5ube5N9i4LYUJO2nFTQdtX2uYZZYO/kj+sZOtxCATYlHXos7CiUfnddqxHec8P9vOTNkw4Vcb0zKDyh+oLDPVb1LTVldTzt4o6597rbeSZCdqXpaUmw62YTzKBSvENGVmzuaGJgB6MWvCjRhO+JY58CUat0XiEFU1wF4nd7ENf4Wrg1t8yA0Fm/IzXjstXkhrmeSbKAxRCTjxCfR8yZGXXbbtagewBaJMfC5uOspgbRHILdbPQExKmZWm6PJ8bSVES8MiBytQXi3oWECgYEA8kyzbStuoP67zNbqw2cupglwKuPgULBQL5xdV2rHb8vof5lgQw6L284c24wA+iIRJSl+gSY/35CvKkHsu7eX1i/L39vlc35STTN/OqRi9NZ8kVxpxM+C3UsBoGgx+XsDEacAcJrBgOEeOL1HHbew9wqQ7WQoZRj37whrtZ6FPs0CgYEAxpRpRn6EltE5miLQd0GC5NMQU2QVz/yKCU4Jp7WgkFkGB5tXId+iIwaIF0UOpKzYtrgVXwOEE9bikHqsFQLOfcCYRC842uP03VBG+9f0unsRnIvbT78uVAvDQCDXx/FGSRvWuemDOxx/Q1j1ShQ2OZ2tX/3gXoWlOUfe0jmPg68CgYEAoikNKHIZ3yu82nG3usESqlLEvB+4X6gwcjzPB5NSGJM6bjNjBl304k3GaHUBrmYgXWOw45SKyQAXC0wFuPg9aT6hzpdnr+0J/dsKOmAMTlpCEjLsIqjSp3Hsi8NQNuzJ+AVxuOsJuExxon2i29O1XxC2P/p5Qnf8bwCOvYVzHb0CgYEApKcB81WMEpFAtbEQMRG8uobXDo36GA5JVhXCo7BRhd6KxVvkD04iXfBYfxLfZWN7/WT9M17y8JBII4vTi0hcdqBuoHqXJcfFjIu3j7IsVUMeAzNjkOfwPffS2SViRYKkyJGwpU4dZbHnQ6xLFjVUEMnQq7sRgs5FhQ02kBDyEjkCgYEA7rZq5kX97Xn9/Nq2bR89UAN4EsoB8+dcqVGN+Ix7TQAHBye7xi0Mau3D8FpIvnjEGMFdChKH0ymvarzYCJkIAZJWdF8eVTd/twfgK5Pk3lO/ApdYe8vkPAdkPlSgYOcn6s/zBEwlyYwNgPH1djcibW2WWCps4tsPMDaqrt7crUc=",
		//支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
		'alipay_public_key' => "MIIBIjAN ujDH9w2RbEKkItWsbhcepAHUEip94x48qDUfVJ1t+s1tWQkuiPd3zkUXFBm2wG3C/Xeprv3sWGvWLnCTXnfvKnZOQBnd6x1ANVkb0iZsM1upu/TFhmznk7Q+1UBzYVvJVWDLiZ0K6Z88s+pGvE6WmuUKRFiIdMqswNK8asxAUrlU6BIloJxsMeoFxpxRulm0yPq/MFqPfA2MTs32o6R0MUGBlKalal2O5g0FfbkBSf250TpVvRT84e4pblOhLm5JYpqFm9swQKrnDwgDXsTPLDVCsabIGCd8Uxu0hhjAQCInmzq+F+6uQSU6/xoWfvHLUPA5OJjYvIOhnxF56ZuEGQIDAQAB",

		//异步通知地址
		'notify_url' => "http://".$_SERVER['HTTP_HOST']."/index.php/recharge_alipay/notifyapp",
		
		//同步跳转
		'return_url' => "http://".$_SERVER['HTTP_HOST']."/index.php/recharge_alipay/returnapp",

		//编码格式
		'charset' => "UTF-8",

		//签名方式
		'sign_type'=>"RSA2",

		//支付宝网关
		'gatewayUrl' => "https://openapi.alipay.com/gateway.do",

);