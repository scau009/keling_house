<?php


namespace App\Services;


use App\Document\SystemConfig;
use Symfony\Component\HttpFoundation\Request;

class SystemConfigService
{
    public function getConfigByRequest(Request $request)
    {
        $config = new SystemConfig();
        $config->setCleanPrice($request->get('cleanPrice'));
        $config->setContactMobile($request->get('contactMobile'));
        $config->setDepositMonth($request->get('depositMonth'));
        $config->setElectricityPrice($request->get('electricityPrice'));
        $config->setKeyPrice($request->get('keyPrice'));
        $config->setManagementPrice($request->get('managementPrice'));
        $config->setNetworkPrice($request->get('networkPrice'));
        $config->setNotice($request->get('notice'));
        $config->setOwner($request->get('owner'));
        $config->setTvPrice($request->get('tvPrice'));
        $config->setOtherPrice($request->get('otherPrice'));
        $config->setWaterAndElectricityLossNumber($request->get('waterAndElectricityLossNumber'));
        $config->setWaterPrice($request->get('waterPrice'));
        return $config;
    }
}