<?php
/**
 * mta平台html5应用统计api sdk，详情接口信息及错误说明请访问 http://docs.developer.qq.com/mta/fast_access/h5/api.html
 * Date:    17-11-7
 * Author:  loliko
 * Ver:     1.0
 *
 * Func
 * public historyData       应用历史趋势数据
 * public hourData          应用小时数据
 * public heartData         应用心跳数据
 * public 实时访客           realTimeData
 * public 新老访客比          compareData
 * public 用户画像           getUserPortrait
 * public 地区数据           areaData
 * public 省市数据           provinceData
 * public 运营商数据         operatorData
 * public 终端属性列表        paraData
 * public 终端信息           paraContentData
 * public 终端属性列表        pageData
 * public 性能监控           pageSpeedData
 * public 访问深度           depthData
 * public 外部链接           sourceData
 * public 入口页面           landData
 * public 离开页面           exitData
 * public 自定义时间         customData
 * public 渠道效果分析        adTagData
 */

namespace Loliko;

use GuzzleHttp;

class MtaApi
{
    // mta平台h5应用appid
    private $_app_id;

    // mta平台h5应用secret
    private $_secret_key;

    private static $_instance = null;

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

    //客户端分析,地区数据,按天查询地区的pv\uv\vv\iv量
    const CTR_AREA_API = 'http://mta.qq.com/h5/api/ctr_area/get_by_area';

    //省市数据,按天查询省市下有流量的城市的pv\uv\vv\iv量
    const CTR_PROVINCE_API = 'http://mta.qq.com/h5/api/ctr_area/get_by_province';

    //运营商,按天查询运营商的pv\uv\vv\iv量
    const CTR_OPERATOR_API = 'http://mta.qq.com/h5/api/ctr_operator';

    //终端属性列表,按天查询对应属性的终端信息数据
    const CTR_PARA_API = 'http://mta.qq.com/h5/api/ctr_client/get_by_para';

    //按天查询终端信息数据
    const CTR_CLIENT_API = 'http://mta.qq.com/h5/api/ctr_client/get_by_content';

    //页面排行,按天查询url的pv\uv\vv\iv数据
    const CTR_PAGE_API = 'http://mta.qq.com/h5/api/ctr_page';

    //性能监控,按天查询对应省市的访问延时与解析时长
    const CTR_SPEED_API = 'http://mta.qq.com/h5/api/ctr_page_speed';

    //访问深度,按天查询用户访问深度
    const CTR_DEPTH_API = 'http://mta.qq.com/h5/api/ctr_depth';

    //来源分析,外部链接,按天查询外部同站链接带来的流量情情况
    const CTR_SOURCE_API = 'http://mta.qq.com/h5/api/ctr_source_out';

    //入口页面,按天查询用户最后访问的进入次数与跳出率
    const CTR_LAND_API = 'http://mta.qq.com/h5/api/ctr_page_land';

    //离开页面,按天查询最后访问页面的离次数
    const CTR_PAGEEXIT_API = 'http://mta.qq.com/h5/api/ctr_page_exit';

    //自定义事件,按天查询自定义事件的pv\uv\vv\iv
    const CTR_CUSTOM_API = 'http://mta.qq.com/h5/api/ctr_custom';

    //渠道效果统计,渠道效果分析,按天查询渠道的分析数据
    const CTR_ADTAG_API = 'http://mta.qq.com/h5/api/ctr_adtag';


    /**
     * MtaApi constructor.
     * @param $app_id
     * @param $secret_key
     */
    public function __construct($app_id, $secret_key)
    {
        $this->_app_id     = $app_id;
        $this->_secret_key = $secret_key;
        $this->_httpClient = new GuzzleHttp\Client();
    }

    //获取实例
    public static function getInstance($app_id = '', $secret_key = '')
    {
        if (!self::$_instance) {
            self::$_instance = new self($app_id, $secret_key);
        }
        return self::$_instance;
    }

    /**
     * 应用历史趋势数据
     * @param $startDate
     * @param $endDate
     * @param $idx
     * @return array|mixed
     */
    public function historyData($startDate, $endDate, $idx)
    {
        $params = [
            'app_id'     => $this->_app_id,
            'start_date' => $startDate,
            'end_date'   => $endDate,
            'idx'        => $idx,
        ];

        $params['sign'] = $this->_makeSign($params);
        return $this->_request(self::CTR_CORE_API, $params);
    }


    /**
     * 应用小时数据
     * @param $idx
     * @return array|mixed
     */
    public function hourData($idx)
    {
        $params = [
            'app_id' => $this->_app_id,
            'idx'    => $idx,
        ];

        $params['sign'] = $this->_makeSign($params);
        return $this->_request(self::GET_BY_HOUR_API, $params);
    }

    /**
     * 应用心跳数据
     * @return array|mixed
     */
    public function heartData()
    {
        $params = [
            'app_id' => $this->_app_id,
        ];

        $params['sign'] = $this->_makeSign($params);
        return $this->_request(self::HEART_BEAT_API, $params);
    }

    /**
     * 实时访客
     * @param $page
     * @return array|mixed
     */
    public function realTimeData($page)
    {
        $params = [
            'app_id' => $this->_app_id,
            'page'   => $page,
        ];

        $params['sign'] = $this->_makeSign($params);
        return $this->_request(self::CTR_REALTIME, $params);
    }

    /**
     * 新老访客比
     * @param $startDate
     * @param $endDate
     * @return array|mixed
     */
    public function compareData($startDate, $endDate)
    {
        $params = [
            'app_id'     => $this->_app_id,
            'start_date' => $startDate,
            'end_date'   => $endDate,
        ];

        $params['sign'] = $this->_makeSign($params);
        return $this->_request(self::CTR_COMPARE, $params);
    }

    /**
     * 用户画像
     * @param $startDate
     * @param $endDate
     * @param $idx
     * @return array|mixed
     */
    public function getUserPortrait($startDate, $endDate, $idx)
    {
        $params = [
            'app_id'     => $this->_app_id,
            'start_date' => $startDate,
            'end_date'   => $endDate,
            'idx'        => $idx,
        ];

        $params['sign'] = $this->_makeSign($params);
        return $this->_request(self::USER_PORTRAIT, $params);
    }

    /**
     * 地区数据
     * @param $typeIds
     * @param $startDate
     * @param $endDate
     * @param $idx
     * @return array|mixed
     */
    public function areaData($typeIds, $startDate, $endDate, $idx)
    {
        $params = [
            'app_id'     => $this->_app_id,
            'start_date' => $startDate,
            'end_date'   => $endDate,
            'idx'        => $idx,
            'type_ids'   => $typeIds,
        ];

        $params['sign'] = $this->_makeSign($params);
        return $this->_request(self::CTR_AREA_API, $params);
    }

    /**
     * 省市数据
     * @param $typeIds
     * @param $startDate
     * @param $endDate
     * @param $idx
     * @return array|mixed
     */
    public function provinceData($typeIds, $startDate, $endDate, $idx)
    {
        $params = [
            'app_id'     => $this->_app_id,
            'start_date' => $startDate,
            'end_date'   => $endDate,
            'idx'        => $idx,
            'type_ids'   => $typeIds,
        ];

        $params['sign'] = $this->_makeSign($params);
        return $this->_request(self::CTR_PROVINCE_API, $params);
    }

    /**
     * 运营商数据
     * @param $typeIds
     * @param $startDate
     * @param $endDate
     * @param $idx
     * @return array|mixed
     */
    public function operatorData($typeIds, $startDate, $endDate, $idx)
    {
        $params = [
            'app_id'     => $this->_app_id,
            'start_date' => $startDate,
            'end_date'   => $endDate,
            'idx'        => $idx,
            'type_ids'   => $typeIds,
        ];

        $params['sign'] = $this->_makeSign($params);
        return $this->_request(self::CTR_OPERATOR_API, $params);
    }

    /**
     * 终端属性列表
     * @param $typeId
     * @param $startDate
     * @param $endDate
     * @param $idx
     * @return array|mixed
     */
    public function paraData($typeId, $startDate, $endDate, $idx)
    {
        $params = [
            'app_id'     => $this->_app_id,
            'start_date' => $startDate,
            'end_date'   => $endDate,
            'idx'        => $idx,
            'type_id'    => $typeId,
        ];

        $params['sign'] = $this->_makeSign($params);
        return $this->_request(self::CTR_PARA_API, $params);
    }

    /**
     * 终端信息
     * @param $typeId
     * @param $typeContents
     * @param $startDate
     * @param $endDate
     * @param $idx
     * @return array|mixed
     */
    public function paraContentData($typeId, $typeContents, $startDate, $endDate, $idx)
    {
        $params = [
            'app_id'        => $this->_app_id,
            'start_date'    => $startDate,
            'end_date'      => $endDate,
            'idx'           => $idx,
            'type_id'       => $typeId,
            'type_contents' => $typeContents,
        ];

        $params['sign'] = $this->_makeSign($params);
        return $this->_request(self::CTR_PARA_API, $params);
    }

    /**
     * 终端属性列表
     * @param $urls
     * @param $startDate
     * @param $endDate
     * @param $idx
     * @return array|mixed
     */
    public function pageData($urls, $startDate, $endDate, $idx)
    {
        $params = [
            'app_id'     => $this->_app_id,
            'start_date' => $startDate,
            'end_date'   => $endDate,
            'idx'        => $idx,
            'urls'       => $urls,
        ];

        $params['sign'] = $this->_makeSign($params);
        return $this->_request(self::CTR_PAGE_API, $params);
    }

    /**
     * 性能监控
     * @param $type
     * @param $typeContents
     * @param $startDate
     * @param $endDate
     * @param $idx
     * @return array|mixed
     */
    public function pageSpeedData($type, $typeContents, $startDate, $endDate, $idx)
    {
        $params = [
            'app_id'        => $this->_app_id,
            'start_date'    => $startDate,
            'end_date'      => $endDate,
            'idx'           => $idx,
            'type'          => $type,
            'type_contents' => $typeContents,
        ];

        $params['sign'] = $this->_makeSign($params);
        return $this->_request(self::CTR_SPEED_API, $params);
    }

    /**
     * 访问深度
     * @param $startDate
     * @param $endDate
     * @return array|mixed
     */
    public function depthData($startDate, $endDate)
    {
        $params = [
            'app_id'     => $this->_app_id,
            'start_date' => $startDate,
            'end_date'   => $endDate,
        ];

        $params['sign'] = $this->_makeSign($params);
        return $this->_request(self::CTR_DEPTH_API, $params);
    }

    /**
     * 外部链接
     * @param $urls
     * @param $startDate
     * @param $endDate
     * @param $idx
     * @return array|mixed
     */
    public function sourceData($urls, $startDate, $endDate, $idx)
    {
        $params = [
            'app_id'     => $this->_app_id,
            'start_date' => $startDate,
            'end_date'   => $endDate,
            'idx'        => $idx,
            'urls'       => $urls,
        ];

        $params['sign'] = $this->_makeSign($params);
        return $this->_request(self::CTR_SOURCE_API, $params);
    }

    /**
     * 入口页面
     * @param $urls
     * @param $startDate
     * @param $endDate
     * @return array|mixed
     */
    public function landData($urls, $startDate, $endDate)
    {
        $params = [
            'app_id'     => $this->_app_id,
            'start_date' => $startDate,
            'end_date'   => $endDate,
            'urls'       => $urls,
        ];

        $params['sign'] = $this->_makeSign($params);
        return $this->_request(self::CTR_LAND_API, $params);
    }

    /**
     * 离开页面
     * @param $urls
     * @param $startDate
     * @param $endDate
     * @return array|mixed
     */
    public function exitData($urls, $startDate, $endDate)
    {
        $params = [
            'app_id'     => $this->_app_id,
            'start_date' => $startDate,
            'end_date'   => $endDate,
            'urls'       => $urls,
        ];

        $params['sign'] = $this->_makeSign($params);
        return $this->_request(self::CTR_PAGEEXIT_API, $params);
    }

    /**
     * 自定义时间
     * @param $custom
     * @param $startDate
     * @param $endDate
     * @param $idx
     * @return array|mixed
     */
    public function customData($custom, $startDate, $endDate, $idx)
    {
        $params = [
            'app_id'     => $this->_app_id,
            'start_date' => $startDate,
            'end_date'   => $endDate,
            'idx'        => $idx,
            'custom'     => $custom,
        ];

        $params['sign'] = $this->_makeSign($params);
        return $this->_request(self::CTR_CUSTOM_API, $params);
    }

    /**
     * 渠道效果分析
     * @param $adTags
     * @param $startDate
     * @param $endDate
     * @param $idx
     * @return array|mixed
     */
    public function adTagData($adTags, $startDate, $endDate, $idx)
    {
        $params = [
            'app_id'     => $this->_app_id,
            'start_date' => $startDate,
            'end_date'   => $endDate,
            'idx'        => $idx,
            'adtags'     => $adTags,
        ];

        $params['sign'] = $this->_makeSign($params);
        return $this->_request(self::CTR_ADTAG_API, $params);
    }

    /**
     * 请求接口方法
     * @param $url 接口地址
     * @param $params 接口参数
     * @return array|mixed
     */
    private function _request($url, $params)
    {
        $result = $this->_httpClient->request('GET', $url, ['query' => $params])->getBody()->getContents();
        if ($result) {
            return json_decode($result, true);
        }
        return [];
    }

    /**
     * 封装签名sign
     * @param $params 需要发送的数据包
     */
    private function _makeSign($params)
    {
        $secret = $this->_secret_key;
        ksort($params);
        foreach ($params as $key => $value) {
            $secret .= $key . '=' . $value;
        }
        return md5($secret);
    }
}