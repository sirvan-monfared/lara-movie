<?php

namespace App\Kodesign;

use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;

class Shamsi
{
    protected $provider;

    public function __construct(){
        $this->provider = new Verta();
    }

    /**
     * Returns the current shamsi date
     *
     * @return Verta
     */
    public function now(){
        return $this->provider->now();
    }

    /**
     * Parses the given shamsi date
     *
     * @param $date
     * @return Shamsi
     */
    public function parse($date){
        $this->provider = $this->provider->parse($date);

        return $this;
    }

    public function setCurrentTime(){
        $this->provider = $this->provider->setTimeString(date('H:i:s'));

        return $this;
    }

    /**
     * @param $carbon
     * @return Verta
     */
    public function fromCarbon($carbon) {
        return verta($carbon);
    }

    /**
     * Returns the carbon instance of current shamsi date
     *
     * @param bool $setCurrentTime
     * @return Carbon
     */
    public function toCarbon($setCurrentTime = false){
        if ($setCurrentTime) {
            $this->setCurrentTime();
        }

        return Carbon::instance($this->provider->DateTime());
    }
}
