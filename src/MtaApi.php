<?php
/**
 * Created by PhpStorm.
 * User: loliko
 * Date: 17-11-7
 * Time: 下午8:03
 * mta平台html5应用统计api sdk，详情接口信息及错误说明请访问 http://docs.developer.qq.com/mta/fast_access/h5/api.html
 */

namespace Loliko;
use GuzzleHttp;

class MtaApi
{
    // mta平台h5应用appid
    private $_app_id;

    // mta平台h5应用secret
    private $_secret_key;

    //http请求对象
    private $_httpClient;

    //应用历史趋势接口,应用每天的pv\uv\vv\iv数据
    const CTR_CORE_API = 'http://mta.qq.com/h5/api/ctr_core_data';

    //应用实时小时数据,应用当天每小时的pv\uv\vv\iv数据
    const GET_BY_HOUR_API = 'http://mta.qq.com/h5/api/ctr_realtime/get_by_hour';

    //应用心跳数据,应用当前pv\uv\vv\iv心跳数据数据
    const HEART_BEAT_API = 'http://mta.qq.com/h5/api/ctr_realtime/heartbeat';

    //实时访客,应用在24小时内的实时访客信息
    const CTR_REALTIME = 'http://mta.qq.com/h5/api/ctr_user_realtime';

    //新老访客比,按天查询当天新访客与旧访客的数量
    const CTR_COMPARE = 'http://mta.qq.com/h5/api/ctr_user_compare';

    //用户画像
    const USER_PORTRAIT = 'http://mta.qq.com/h5/api/ctr_user_portrait';

    /**
     * MtaApi constructor.
     * @param $app_id
     * @param $secret_key
     */
    public function __construct($app_id , $secret_key)
    {
        $this->_app_id = $app_id;
        $this->_secret_key = $secret_key;
        $this->_httpClient = new GuzzleHttp\Client();
    }

    public function getUserPortrait($startDate , $endDate , $idx)
    {
        $params = [
            'app_id' => $this->_app_id,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'idx' => $idx,
        ];

        $params['sign'] = $this->_makeSign($params);
        return $this->_request(self::USER_PORTRAIT , $params);
    }

    private function _request($url , $params)
    {
        $result = $this->_httpClient->request('GET' , $url , ['query' => $params])->getBody()->getContents();
        if($result){
            return json_decode($result , true);
        }
        return [];
    }

    /**
     * 封装签名sign
     * @param $paramArr 需要发送的数据包
     */
    private function _makeSign($params){
        $secret = $this->_secret_key;
        ksort($params);
        foreach ($params as $key => $value) {
            $secret.= $key.'='.$value;
        }
        return md5($secret);
    }
}