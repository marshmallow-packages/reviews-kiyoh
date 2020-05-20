<?php

namespace Marshmallow\Reviews\Kiyoh;

use Illuminate\Support\Facades\Http;
use Marshmallow\Reviews\Kiyoh\Exceptions\KiyohException;
use Marshmallow\Reviews\Kiyoh\Exceptions\KiyohInviteException;
use Marshmallow\Reviews\Kiyoh\Http\Resources\KiyohInviteResource;

class KiyohInvite
{
    protected $email;
    protected $language;
    protected $delay;
    protected $first_name;
    protected $last_name;
    protected $ref_code;
    protected $city;
    protected $variable;
    protected $supplier;

    protected $languages = [
        'en', 'nl', 'fi-FI', 'fr', 'be', 'de', 'hu', 'bg',
        'ro', 'hr', 'ja', 'es-ES', 'it', 'pt-PT', 'tr', 
        'nn-NO', 'sv-SE', 'da', 'pt-BR', 'pl', 'sl', 'zh-CN', 
        'ru', 'el', 'cs', 'et', 'lt', 'lv', 'sk'
    ];

	public function __construct ()
	{
        //
	}

	public function email ($email)
	{
		$this->email = $email;
		return $this;
	}

    public function getEmail ()
    {
        return $this->email;
    }

    /**
     * Taal waarin je de uitnodiging wil verzenden
     * @param  [type] $language [description]
     * @return [type]           [description]
     */
    public function language ($language)
    {
        $this->language = $language;
        return $this;
    }

    public function getLanguage ()
    {
        $language = ($this->language) ?? config('kiyoh.language');
        if (!$language) {
            throw new KiyohException("Please provide a language through the config or language() method.");
        }
        if (!in_array($language, $this->languages)) {
            throw new KiyohException("Language `$language` is not supported by Kiyoh");
        }

        return $language;
    }

    public function delay (int $delay)
    {
        $this->delay = $delay;
        return $this;
    }

    public function getDelay (): int
    {
        $delay = ($this->delay) ?? config('kiyoh.delay');
        if ($delay === null) {
            throw new KiyohException("Please provide a delay.");
        }
        return $delay;
    }

    public function firstName ($first_name)
    {
        $this->first_name = $first_name;
        return $this;
    }

    public function getFirstName ()
    {
        return $this->first_name;
    }

    public function lastName ($last_name)
    {
        $this->last_name = $last_name;
        return $this;
    }

    public function getLastName ()
    {
        return $this->last_name;
    }

    /**
     * Referentiecode voor je eigen administratie (zichtbaar in de geschiedenis)
     * @param  [type] $ref_code [description]
     * @return [type]           [description]
     */
    public function refCode ($ref_code)
    {
        $this->ref_code = $ref_code;
        return $this;
    }

    public function getRefCode ()
    {
        return $this->ref_code;
    }

    /**
     * City field
     * @param  [type] $city [description]
     * @return [type]       [description]
     */
    public function city ($city)
    {
        $this->city = $city;
        return $this;
    }

    public function getCity ()
    {
        return $this->city;
    }

    /**
     * as created by location or LG in questionnaire
     * @param  [type] $variable [description]
     * @return [type]           [description]
     */
    public function variable ($variable)
    {
        $this->variable = $variable;
        return $this;
    }

    public function getVariable ()
    {
        return $this->variable;
    }

    /**
     * name of Location that needs to be displayed on the Form (instead of name from Location)
     * @param  [type] $supplier [description]
     * @return [type]           [description]
     */
    public function supplier ($supplier)
    {
        $this->supplier = $supplier;
        return $this;
    }

    public function getSupplier ()
    {
        return $this->supplier;
    }

	public function invite ()
	{
        $data = [
            'hash' => env('KIYOH_HASH', config('kiyoh.hash')),
            'location_id' => env('KIYOH_LOCATION_ID', config('kiyoh.location_id')),
            'invite_email' => $this->getEmail(),
            'delay' => $this->getDelay(),
            'supplier' => $this->getSupplier(),
            'first_name' => $this->getFirstName(),
            'last_name' => $this->getLastName(),
            'language' => $this->getLanguage(),
            'ref_code' => $this->getRefCode(),
            'city' => $this->getCity(),
            'variable' => $this->getVariable(),
        ];

		$response = Http::get(config('kiyoh.invite_path'), $data);
		if (!$response->successful()) {
			throw new KiyohInviteException($response->json());
		}

        return new KiyohInviteResource($response);
	}
}
