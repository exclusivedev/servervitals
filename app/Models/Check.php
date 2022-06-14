<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Check extends Model
{
    //
    public function getClassAttribute()
    {
        switch ($this->type) {
            case 'elasticsearch':
            case 'memcached':
            case 'mysql':
            case 'apache':
            case 'nginx':
            case 'beanstalkd':
                return 'switch';
            case 'diskspace':
            case 'cpu':
            case 'memory':
                return 'number';
        };
    }

    public function getValueAttribute()
    {
        if ($this->isNumber()) {
            preg_match('/((\d*\.)?\d+)%/', $this->last_run_message, $pieces);
            if (!empty($pieces)) {
                return (float) $pieces[0];
            }
        } else if ($this->isSwitch()) {
            if ($this->last_run_message == 'is running') {
                return ($this->status == 'success');
            }

            return ($this->status != 'failed');
        }
    }

    public function getThresholdStatusAttribute()
    {
        $configs = [
            'diskspace' => 'server-monitor.diskspace_percentage_threshold',
            'cpu' => 'server-monitor.cpu_usage_threshold',
            'memory' => 'server-monitor.memory_usage_threshold'
        ];
        $config = config($configs[$this->type]);
        return ($this->value >= $config['fail']) ? 'danger' : (($this->value >= $config['warning']) ? 'warning' : '');
    }

    public function isNumber()
    {
        return $this->class === 'number';
    }

    public function isSwitch()
    {
        return $this->class === 'switch';
    }

    public function scopeEnabled($q)
    {
        return $q->where('enabled', 1);
    }
}
