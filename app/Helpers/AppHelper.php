<?php


namespace App\Helpers;

use Exception;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;
use NumberFormatter;

class AppHelper
{
    public static function instance()
    {
        return new AppHelper();
    }

    public function retfloat($number)
    {
        return number_format((float)$number, 2, '.', '');
    }

    public function formatCurrency(float $amount)
    {
        $value = number_format($amount, 2, '.', ',');

        return strtr('{SYMBOL} {VALUE}', [
            '{VALUE}' => $value,
            '{SYMBOL}' => '₹',
            '{CODE}' => 'rupee',
        ]);
    }

    public function getAmountInWords(float $amount)
    {
        $amount = number_format($amount, 2, '.', '');
        $formatter = new NumberFormatter($locale ?? App::getLocale(), NumberFormatter::SPELLOUT);

        $value = explode('.', $amount);

        $integer_value = (int)$value[0] !== 0 ? $formatter->format($value[0]) : 0;
        $fraction_value = isset($value[1]) ? $formatter->format($value[1]) : 0;

        return ucwords(sprintf('%s %s and %s %s', $integer_value, 'rupee', $fraction_value, 'paise'));
    }

    public function randomid($length = 10)
    {
        return substr(md5(time() * rand(100000, 999999)), 0, $length);
    }

    function html2text($text)
    {
        $text = strip_tags($text, '<br><p><li>');
        $text = preg_replace('/<[^>]*>/', PHP_EOL, $text);

        return $text;
    }

    public static function uploadFileToStorage($file, $fileNamePath)
    {
        if (config('filesystems.disks.s3.enabled')) {
            $file->storeAs('', $fileNamePath, 's3');
            return config('filesystems.disks.s3.url') . $fileNamePath;
        }

        $file->storeAs('', $fileNamePath, 'public');
        return config('app.url') . '/storage/' . $fileNamePath;
    }

    public function formatEmailId($email)
    {
        $email = str_replace('<', '&lt;', $email);
        $email = str_replace('>', '&gt;', $email);

        return $email;
    }

    public function validateEmailArray($emails)
    {
        $newemails = [];
        foreach ($emails as $email) {
            if ($email) {
                $email = explode('<', $email);
                $email = (sizeof($email) > 1) ? $email[1] : $email[0];

                $email = explode('>', $email)[0];
                $newemails[] = $email;
            }
        }
        return $newemails;
    }

    public function validateMultipleEmailSeparatedByComma($emails)
    {
        if (isset($emails)) {
            foreach (explode(',', $emails) as $email) {
                $valicator = Validator::make(['email' => $email], [
                    'email' => 'required|email|regex:/(.+)@(.+)\.(.+)/i'
                ]);

                if ($valicator->fails()) {
                    return $email;
                }
            }
//            return 0;
        }
    }

    public static function isTester($request)
    {
        return $request->header('appTester') == 'true';
    }

    public function randomDigits($length = 6)
    {
        return rand(pow(10, $length - 1), pow(10, $length) - 1);
    }

    function imageToDataUrl(string $filename): string
    {
        if (!file_exists($filename)) {
            throw new Exception('File not found.');
        }

        $mime = mime_content_type($filename);
        if ($mime === false) {
            throw new Exception('Illegal MIME type.');
        }

        $raw_data = file_get_contents($filename);
        if (empty($raw_data)) {
            throw new Exception('File not readable or empty.');
        }

        return "data:{$mime};base64," . base64_encode($raw_data);
    }
}
