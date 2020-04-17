<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected $showSensitveFields = false;
    public function toArray($request)
    {
        if(!$this->showSensitveFields){
            $this->resource->addHidden(['phone','email']);
        }
        $data = parent::toArray($request);
        $data['bound_phone'] = $this->resource->phone ? true : false;
        $data['bound_wechat'] = ($this->resource->weixin_unionid ||
            $this->resource->weixin_openid) ? true : false;

        return $data;
    }

    public function showSensitiveFields()
    {
        $this->showSensitveFields = true;
        return $this;
    }
}
