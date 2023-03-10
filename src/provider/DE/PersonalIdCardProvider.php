<?php

namespace Didasto\CustomFaker\DE;

use DateTimeInterface;

class PersonalIdCardsProvider extends Faker\Provider\Base
{
    public function passportCardNumber(?DateTimeInterface $expiredDate = null, int $customerAge = 20, string $gender = 'M'): string
    {
        $serial = $this->regexify('[CFGHJK][0-9CFGHJKLMNPRTVWXYZ]{8}');
        $serial .= $this->getIdentityChecksum($serial);
        $country = 'D';
        $age     = date('ymd', strtotime('- '.$customerAge.' years'));
        $age .= $this->getIdentityChecksum($age);
        if ($expiredDate) {
            $expire = $expiredDate->format('ymd');
        } else {
            $expire = date('ymd', strtotime('+5 years'));
        }
        $expire .= $this->getIdentityChecksum($expire);
        if (in_array($gender, ['M', 'F'])) {
            $gender = 'M';
        }

        return $serial.$country.$age.$gender.$expire.$this->getIdentityChecksum($serial.$age.$expire, -2);
    }

    public function idCardNumber(?DateTimeInterface $expiredDate = null, int $customerAge = 18): string
    {
        $serial = $this->regexify('[LMNPRTVWXY][0-9CFGHJKLMNPRTVWXYZ]{8}');
        $serial .= $this->getIdentityChecksum($serial);
        $age = date('ymd', strtotime('- '.$customerAge.' years'));
        $age .= $this->getIdentityChecksum($age);

        if ($expiredDate) {
            $expire = $expiredDate->format('ymd');
        } else {
            $expire = date('ymd', strtotime('+5 years'));
        }
        $expire .= $this->getIdentityChecksum($expire);

        return $serial.$age.$expire.'D'.$this->getIdentityChecksum($serial.$age.$expire);
    }

    protected function getIdentityChecksum(string $value, int $offset = -1): string
    {
        $p   = 7;
        $sum = 0;
        for ($i = 0; $i < strlen($value); ++$i) {
            $char = $value[$i];
            $int  = $char >= '0' && $char <= '9' ? (int) $char : ord($char) - 55;
            $sum += $int * $p;
            match ($p) {
                1 => $p = 7,
                3 => $p = 1,
                7 => $p = 3,
            };
        }

        return substr((string) $sum, $offset);
    }
}
