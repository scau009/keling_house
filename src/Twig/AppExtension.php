<?php

namespace App\Twig;

use App\Document\Room;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
            new TwigFilter('trans_room_status', [$this, 'trans_room_status']),
            new TwigFilter('trans_sex', [$this, 'trans_sex']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('getRoomStatus', [$this, 'getRoomStatus']),
        ];
    }

    public function trans_room_status($value)
    {
        $map = [
            Room::STATUS_OPEN => '开放出租',
            Room::STATUS_BUSY => '已入住',
            Room::STATUS_CLEANING => '清洁中',
        ];
        return $map[$value];
    }

    public function trans_sex($sex)
    {
        if ($sex == 1) {
            return '男';
        }else{
            return '女';
        }
    }

    public function getRoomStatus()
    {
        return [
            ['value' => Room::STATUS_OPEN, 'label' => '开放出租',],
            ['value' => Room::STATUS_BUSY, 'label' => '已入住',],
            ['value' => Room::STATUS_CLEANING, 'label' => '清洁中',],
        ];
    }

}
