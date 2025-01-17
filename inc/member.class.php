
<?php
/**
 * ---------------------------------------------------------------------
 * ITSM-NG
 * Copyright (C) 2022 ITSM-NG and contributors.
 *
 * https://www.itsm-ng.org
 *
 * based on GLPI - Gestionnaire Libre de Parc Informatique
 * Copyright (C) 2003-2014 by the INDEPNET Development Team.
 *
 * ---------------------------------------------------------------------
 *
 * LICENSE
 *
 * This file is part of ITSM-NG.
 *
 * ITSM-NG is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * ITSM-NG is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with ITSM-NG. If not, see <http://www.gnu.org/licenses/>.
 * ---------------------------------------------------------------------
 */

class PluginWorkshopMember extends CommonDBTM
{

    static private $nameList = [
        'alemarchand',
    ];

    static function install()
    {
        global $DB;

        $query = <<<SQL
        CREATE TABLE IF NOT EXISTS `glpi_plugin_workshop_members` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        SQL;

        if (!$DB->query($query)) {
            return false;
        }
        $insertQuery = 'INSERT INTO `glpi_plugin_workshop_members` (`name`) VALUES ';
        foreach (self::$nameList as $name) {
            $insertQuery .= "('$name'),";
        }
        $insertQuery = substr($insertQuery, 0, -1);
        if (!$DB->query($insertQuery)) {
            return false;
        }

        return true;
    }

    static function uninstall()
    {
        global $DB;

        $query = <<<SQL
            DROP TABLE IF EXISTS `glpi_plugin_workshop_members`;
        SQL;

        $DB->query($query);

        return true;
    }

    static function getMenuContent(): array
    {
        $menu = [
            'title' => 'Members',
            'page' => Plugin::getPhpDir('workshop', false) . '/front/member.php',
            'icon' => 'fas fa-user-graduate'
        ];

        return $menu;
    }

    function showForm()
    {
        echo $this->fields['name'];
    }

    function rawSearchOptions()
    {
        $tab = [
            [
                'id' => 2,
                'table' => self::getTable(),
                'name' => __("Name"),
                'field' => 'name',
            ]
        ];
        return $tab;
    }
}
