<?php

namespace fw\libs;

class Cache
{
    public function __construct()
    {

    }

    /**
     * $key  имя данных
     * $data сами данные
     * $seconds время в сеундах на которое мы эти данные кладем
     * кладет данные в файо
     */
    public function set($key, $data, int $seconds = 3600): bool
    {
        /**
         * высчитаем до какого преиода будут актуальны кэшированные данные
         */
        $content['data']     = $data;
        $content['end_time'] = time() + $seconds;

        if (file_put_contents(CACHE.'/'.md5($key).'.txt', serialize($content))) {
            return true;
        }

        return false;
    }

    /**
     * считывем данные из файла
     */
    public function get($key)
    {
        $file    = CACHE.'/'.md5($key).'.txt';

        if (file_exists($file)) {
            $content = unserialize(file_get_contents($file));
            if (time() <= $content['end_time']) {
                return $content['data'];
            }
            unlink($file);
        }

        return false;
    }

    public function delete($key)
    {
        $file = CACHE . '/' . md5($key) . '.txt';

        if (file_exists($file)) {
            unlink($file);
        }
    }
}