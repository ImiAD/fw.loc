<?php

namespace fw\widgets\menu;

use fw\libs\Cache;

class Menu
{
    /**
     * данные
     */
    protected $data;

    /**
     * дерево
     */
    protected $tree;

    /**
     * меню
     */
    protected $menuHtml;

    /**
     * путь к шаблону, для построения html кода меню
     */
    protected $tpl;

    protected string $class = 'select';

    /**
     * отвечает за тег в который нужно обернуть элемент меню
     */
    protected string $container = 'ul';

    /**
     * таблица из которой выбираются данные
     */
    protected string $table = 'categories';

    /**
     * кеширование меню
     */
    protected int $cache = 3600;

    public function __construct(array $options = [])
    {
        $this->tpl = __DIR__ . '/menu_tpl/menu.php';
        $this->getOptions($options);
        $this->run();
    }

    /**
     * переопределяем свойства меню
     */
    protected function getOptions($options)
    {
        foreach ($options as $k => $v) {
            if (property_exists($this, $k)) {
                $this->$k = $v;
            }
        }
    }

    /*
     *  запускает все прочие методы
     */
    protected function run()
    {
        $cache = new Cache();
        $this->menuHtml = $cache->get('fw_menu');

        if (!$this->menuHtml) {
            /**
             * получаем данные из таблицы, ключами будут id из таблицы
             */
            $this->data = \R::getAssoc("SELECT * FROM {$this->table} ");
            $this->tree = $this->getTree();
//        debug($this->tree);
            $this->menuHtml = $this->getMenuHtml($this->tree);
            $cache->set('fw_menu', $this->menuHtml, $this->cache);
        }

        $this->output();
    }

    protected function output()
    {
        echo "<{$this->container} class='{$this->class}'>";
        echo $this->menuHtml;
        echo "</{$this->container}>";
    }

    /**
     * построение дерева
     */
    protected function getTree(): array
    {
        $tree = [];
        $data = $this->data;

        foreach ($data as $id => &$node) {
            if (!$node['parent']) {
                $tree[$id] = &$node;
            } else {
                $data[$node['parent']]['childs'][$id] = &$node;
            }
        }

        return $tree;
    }

    /**
     * формирует html код
     */
    protected function getMenuHtml($tree, string $tab = ''): string
    {
        $str = '';

        foreach ($tree as $id => $category) {
            $str .= $this->catToTemplate($category, $tab, $id);
        }

        return $str;
    }

    /**
     * отправка категории в шаблон
     */
    protected function catToTemplate($category, $tab, $id)
    {
        ob_start();
        require $this->tpl;

        return ob_get_clean();
    }
}