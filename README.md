# Mta-html5-SDK

此项目是腾讯mta平台html5页面统计数据接口sdk，需要php>=5.4。
<br/>
详细使用方式:<br/>
```
第一步：在composer.json里加入扩展包
"require": {
    	"loliko/mta-html5-sdk" : "dev-master"
    }
    
第二步：composer update

第三步：代码示例
require 'vendor/autoload.php';
use Loliko\MtaApi;

$mmd = new MtaApi(你的mta应用appid , '你的mta应用secret');
print_r($mmd->historyData('2017-11-06' , '2017-11-07' , 'uv'));

```

详细接口请求方式和需要的参数信息以及错误码请查阅[接口文档](http://docs.developer.qq.com/mta/fast_access/h5/api.html)
##接口说明
####接口定义
<br/>
 * Func<br/>
 * public historyData       应用历史趋势数据<br/>
 * public hourData          应用小时数据<br/>
 * public heartData         应用心跳数据<br/>
 * public 实时访客           realTimeData<br/>
 * public 新老访客比          compareData<br/>
 * public 用户画像           getUserPortrait<br/>
 * public 地区数据           areaData<br/>
 * public 省市数据           provinceData<br/>
 * public 运营商数据         operatorData<br/>
 * public 终端属性列表        paraData<br/>
 * public 终端信息           paraContentData<br/>
 * public 终端属性列表        pageData<br/>
 * public 性能监控           pageSpeedData<br/>
 * public 访问深度           depthData<br/>
 * public 外部链接           sourceData<br/>
 * public 入口页面           landData<br/>
 * public 离开页面           exitData<br/>
 * public 自定义时间         customData<br/>
 * public 渠道效果分析        adTagData<br/>
 
####接口参数
请根据开发文档以及函数声明传值

#####注意
不能根据返回的code或者info判断接口是否成功，有的方法没有返回这两个数据



## TODO
1.错误处理
<br/>


## 更新进度


-----------------------------2017-11-08----------------------------
<br/>
1.初始化项目
<br/>
