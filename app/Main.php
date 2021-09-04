<?php

namespace Reactmore\Durian;

use Dotenv\Dotenv;
use Reactmore\Durian\Helpers\FileHelper;
use Reactmore\Durian\Helpers\Validations\MainValidator;


class Main
{

    const DOT_ENV = '.env';

    public $credential, $stage;

    public function __construct(array $data = [])
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

        if (empty($data['apiKey'])) {
            $this->credential['apiKey'] = isset($_ENV['DURIAN_APIKEY_' . $this->stage]) ? $_ENV['DURIAN_APIKEY_' . $this->stage] : '';
        } else {
            $this->credential['apiKey'] = $data['apiKey'];
        }

        if (empty($data['privateKey'])) {
            $this->credential['privateKey'] = isset($_ENV['DURIAN_PKEY_' . $this->stage]) ? $_ENV['DURIAN_PKEY_' . $this->stage] : '';
        } else {
            $this->credential['privateKey'] = $data['privateKey'];
        }

        if (empty($data['merchantCode'])) {
            $this->credential['merchantCode'] = isset($_ENV['DURIAN_MERCHANTCODE_' . $this->stage]) ? $_ENV['DURIAN_MERCHANTCODE_' . $this->stage] : '';
        } else {
            $this->credential['merchantCode'] = $data['merchantCode'];
        }
    }
}
