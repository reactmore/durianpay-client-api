<?php

namespace Reactmore\Durianpay;

use Dotenv\Dotenv;
use Reactmore\Durianpay\Helpers\FileHelper;
use Reactmore\Durianpay\Helpers\Validations\MainValidator;


class Main
{

    const DOT_ENV = '.env';

    public $credential, $stage;

    public function __construct($data = [])
    {
        MainValidator::validateCredentialRequest($data);
        $this->setEnvironmentFile();
        $this->setCredential($data);
    }

    private function setEnvironmentFile()
    {
        $envDirectory = FileHelper::getAbsolutePathOfAncestorFile(self::DOT_ENV);

        if (file_exists($envDirectory . '/' . self::DOT_ENV)) {
            $dotEnv = Dotenv::createMutable(FileHelper::getAbsolutePathOfAncestorFile(self::DOT_ENV));
            $dotEnv->load();
        }
    }

    private function setCredential($data)
    {

        if (empty($data['stage'])) {
            $this->stage = isset($_ENV['DURIAN_STAGE']) ? $_ENV['DURIAN_STAGE'] : 'SANDBOX';
        } else {
            $this->stage = $data['stage'];
        }

        $this->stage = strtoupper($this->stage) == 'LIVE' ? 'LIVE' : 'SANDBOX';

        if (empty($data['apikey'])) {
            $this->credential['apikey'] = isset($_ENV['DURIAN_APIKEY_' . $this->stage]) ? $_ENV['DURIAN_APIKEY_' . $this->stage] : '';
        } else {
            $this->credential['apikey'] = $data['apikey'];
        }
    }
}
