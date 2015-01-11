<?php

# Cache Cookie - (C) 2011 Frank Denis - Public domain

define('CACHE_COOKIE_NAME', 'cache');
define('CACHE_COOKIE_SECRET_KEY', '<change this>');
define('CACHE_COOKIE_DIGEST_METHOD', 'md5');
define('CACHE_COOKIE_DURATION', 30 * 60);

class CacheCookie {
    static function set($key, $value, $lifetime) {
        $cookie_content = self::_fetch_cookie_content();
        $now = time();
        $cookie_content->{$key} = array('value' => $value,
                                        'expires_at' => $now + $lifetime);
        $cookie_json = json_encode($cookie_content);
        $cookie = hash_hmac(CACHE_COOKIE_DIGEST_METHOD, $cookie_json,
                            CACHE_COOKIE_SECRET_KEY) . '|' . $cookie_json;
        self::_wipe_previous_cookie(CACHE_COOKIE_NAME);
        setcookie(CACHE_COOKIE_NAME, $cookie, $now + CACHE_COOKIE_DURATION,
                  COOKIES_PATH, COOKIES_DOMAIN, FALSE, TRUE);
        $_COOKIE[CACHE_COOKIE_NAME] = $cookie;

        return TRUE;
    }

    static function get($key) {
        $cookie_content = self::_fetch_cookie_content();
        if (!isset($cookie_content->{$key})) {
            return NULL;
        }
        $entry = $cookie_content->{$key};
        if (!is_object($entry) || !isset($entry->value) ||
            !isset($entry->expires_at) ||
            !is_numeric($entry->expires_at) || time() > $entry->expires_at) {
            self::delete($key);

            return NULL;
        }
        return $entry->value;
    }

    static function delete($key) {
        $cookie_content = self::_fetch_cookie_content();
        $key_existed = isset($cookie_content->{$key});
        unset($cookie_content->{$key});
        $cookie_json = json_encode($cookie_content);
        $cookie = hash_hmac(CACHE_COOKIE_DIGEST_METHOD, $cookie_json,
                            CACHE_COOKIE_SECRET_KEY) . '|' . $cookie_json;
        self::_wipe_previous_cookie(CACHE_COOKIE_NAME);
        setcookie(CACHE_COOKIE_NAME, $cookie, time() + CACHE_COOKIE_DURATION,
                  COOKIES_PATH, COOKIES_DOMAIN, FALSE, TRUE);
        $_COOKIE[CACHE_COOKIE_NAME] = $cookie;

        return $key_existed;
    }

    static function delete_all() {
        self::_wipe_previous_cookie(CACHE_COOKIE_NAME);
        setcookie(CACHE_COOKIE_NAME, '', 1, COOKIES_PATH, COOKIES_DOMAIN,
                  FALSE, TRUE);
        unset($_COOKIE[CACHE_COOKIE_NAME]);
    }

    protected static function _wipe_previous_cookie($cookie_name) {
        $headers = headers_list();
        header_remove();
        $rx = '/^Set-Cookie\\s*:\\s*' . preg_quote($cookie_name) . '=/';
        foreach ($headers as $header) {
            if (preg_match($rx, $header) <= 0) {
                header($header, TRUE);
            }
        }
    }

    protected static function _fetch_cookie_content() {
        $cookie = NULL;
        if (!empty($_COOKIE[CACHE_COOKIE_NAME])) {
            $cookie = $_COOKIE[CACHE_COOKIE_NAME];
        }
        if (empty($cookie)) {
            $cookie_content = new \stdClass();
        } else {
            @list($digest, $cookie_json) = explode('|', $cookie, 2);
            if (empty($digest) || empty($cookie_json) ||
                !self::hash_equals($digest, hash_hmac(CACHE_COOKIE_DIGEST_METHOD, $cookie_json,
                                      CACHE_COOKIE_SECRET_KEY))) {
                $cookie_content = new \stdClass();
            } else {
                $cookie_content = @json_decode($cookie_json);
            }
        }
        if (!is_object($cookie_content)) {
            $cookie_content = new \stdClass();
        }
        return $cookie_content;
    }
    

    /**
     * Prevent timing attack
     * 
     * @param  string $knownString
     * @param  string $userString
     * @return bool
     */
    public static function hash_equals($knownString, $userString)
    {
        if (function_exists('\hash_equals')) {
            return \hash_equals($knownString, $userString);
        }
        if (strlen($knownString) !== strlen($userString)) {
            return false;
        }
        $len = strlen($knownString);
        $result = 0;
        for ($i = 0; $i < $len; $i++) {
            $result |= (ord($knownString[$i]) ^ ord($userString[$i]));
        }
        // They are only identical strings if $result is exactly 0...
        return 0 === $result;
    }
}
