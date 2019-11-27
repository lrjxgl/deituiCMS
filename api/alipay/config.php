<?php
$config = array (	
		//应用ID,您的APPID。
		'app_id' => "2017 ",

		//商户私钥，您的原始格式RSA私钥
		'merchant_private_key' => "MIIEpwyMtxMUzbyztxzirGaTSYbYtNlN1duHnKoEUQB5e25gUeyoZla58ByIjgAXNp4CLe09+cATxJerKOLUCIIS0uBUMyY8uJ2/RdvIMB6xiHd2pXxGEXEELDV8JqY6SPeRRjJK1/9gdBH2FRBYzlgDwy+ZcIlSMa42fgrc4l77AKcYAxsGKETfjhqFCxcx8EdUbe+CzK+uCJxAAa6IaSdHKmE5YAvjNDArE7zG0H9S57eq0K3A+giiJWPn8T/OFfLkIfX2XVAtLbMokdMRrHXB4o9YR1AKMI78ab9onuOmVZvNXgNRVZPUM4PX+kMQIDAQABAoIBAECtIG7aFZiG+s8dWW27afGd00GD7VyqRhAVx6OOFHDXBkoj9FroDSOvFIMGU+1llpxkqkTiPFHxvDPWQFu3+Q6jZDtUk8L8LqJ/V8OD5n2lHLe5Eq1yuYSUo2mOtIXAg7kJLALIIAZN3dN1+0wBeXJPpj8UpK+absC554kjK2mnGS7fb54nd92UGGC2w87ltqG5i7qPZcAhnqbEtPnMfU9p/4NNpV7+KOSy0f54ZJWv9oqG/GihOAC4q5vVtYFgcOLMmV19hgyw3Rn/J0wmft2NqQtsug/mj6Y3VStJxQyFYHPezExvaHRbKElOGn1y4nxAyqNKSmk2KCzuR1l00BECgYEA+HSf61PX8Bg2jkzT9Rb6DaPJ4Gqu+pFaoeOw2iOtKmgBDS0u76NLY4YuJ5BU+d3MyDDkotS290x5jMqT+1jQiVMKAYzpl+eZRt2jhTh1MRfBCPDxMH8LiFuMflzjy69jTv4En6MQ2BYrtcCYQeZ6rCOqnfaWV2xFGDFM/pk8We0CgYEAxuOF0heQOtsBWQPY8RWFxQp7xGPh3wDSA9Kd+c1kOQpPHgeTZdoXXumAp12rBgR7dpmG6eTLJAx3klRnnWCTA3l5MZbajJC0fYYpHUyGnbQlATpMoyNbLdT/gw3fmtskE8dYl9JwAwsi+J5t/ubVDNJFF81rMoU2mJAf0WXp2tUCgYBgI0iKF6xT1BqwH1xY1uY1Bu6jrsQ8YqguQlt5XRqxcQMPJS+nPIl8XjxXxMqM0N1fjUO7GhIeSPIzn2N5e5lducsCZJMy20P9HuAaOYlnUKi6G/lH6bD9t2b6sljWxOvpcfM6DjADXTjWoEqKHXPUTgzECNmNxHBL9y+yyHqI1QKBgQCGuyKwS94cwLeNAZo41wejj5KAW9lrJDcg99CkpIq8SUuHYEJtwOwME8pfloiArxCkKyTF1YP3i6qEqkD2z7FHrUZ4XWT3zB842WWIv4qB0sMurbu02AKwbZYZxZAwaztpWqWdU6UlqqmqGkkRYHX7FYZQtYtk0fFGMHwdchiVcQKBgQDbjanFcIpRwaAKDG25m2ZtjQbGXTsrhkmxdTas6yQ+nd8rqDI66X6a93T386bKYB7IMdg1UHELyTCl5twkzlbb8toKTga2zO8nhT0xphlFFNK4/PimSSzr/YDy5l21bGB78/mkGLhDxqF8dnWwbkJmo3MufQbxU6A9DYN8am19XQ==",
		//异步通知地址
		'notify_url' => "https://".$_SERVER['HTTP_HOST']."/index.php/recharge_alipay_new/notifyapp",
		
		//同步跳转
		'return_url' => "https://".$_SERVER['HTTP_HOST']."/index.php/recharge_alipay_new/returnapp",

		//编码格式
		'charset' => "UTF-8",

		//签名方式
		'sign_type'=>"RSA2",

		//支付宝网关
		'gatewayUrl' => "https://openapi.alipay.com/gateway.do",

		//支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
		'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAttOItsiVg9XM7PFsICWtWB9WlJ7kGqVVd052iV7FSuxEvLV0/CLQC+c8eYwJX91hC8+YX8DHAj9zXRPalrvz0jf/kaa4boPQyhzaioGbTcrZo5MNiduReKjHR7Ib0bzSejwBn6EzMu2YaPEecG0pvB99mA30gr/v4SsAXU31WcYsOXO7i1ek/SD5qgln1jdtEXGvYUWYkKKZyxqOUbVhRJizfmCnmi3vA90oskWQ8D3Pc4DMXFicPjsHilePXi2QKN1TDm3ywWpjcfwj+dEj2Q9IolBNAYnGm/RKoK7HsvBB/pOXrvAFDEZwlcgjIJooKHcFUDG9+KuocTCAYIwNqwIDAQAB"
	
);