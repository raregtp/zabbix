<?php declare(strict_types = 1);
/*
** Zabbix
** Copyright (C) 2001-2022 Zabbix SIA
**
** This program is free software; you can redistribute it and/or modify
** it under the terms of the GNU General Public License as published by
** the Free Software Foundation; either version 2 of the License, or
** (at your option) any later version.
**
** This program is distributed in the hope that it will be useful,
** but WITHOUT ANY WARRANTY; without even the implied warranty of
** MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
** GNU General Public License for more details.
**
** You should have received a copy of the GNU General Public License
** along with this program; if not, write to the Free Software
** Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
**/

class CItemTypeSnmpTrap implements CItemType {

	/**
	 * @inheritDoc
	 */
	const FIELD_NAMES = ['interfaceid'];

	/**
	 * @inheritDoc
	 */
	public static function getCreateValidationRules(array &$item): array {
		return [
			'interfaceid' =>	['type' => API_MULTIPLE, 'rules' => [
									['if' => ['field' => 'host_status', 'in' => implode(',', [HOST_STATUS_MONITORED, HOST_STATUS_NOT_MONITORED])], 'type' => API_ID, 'flags' => API_REQUIRED],
									['else' => true, 'type' => API_UNEXPECTED]
			]]
		];
	}

	/**
	 * @inheritDoc
	 */
	public static function getUpdateValidationRules(array &$item, array $db_item): array {
		return [
			'interfaceid' =>	['type' => API_MULTIPLE, 'rules' => [
									['if' => static function () use ($db_item): bool {
										return in_array($db_item['host_status'], [HOST_STATUS_MONITORED, HOST_STATUS_NOT_MONITORED])
											&& in_array($db_item['type'], [ITEM_TYPE_TRAPPER, ITEM_TYPE_INTERNAL, ITEM_TYPE_ZABBIX_ACTIVE,
												ITEM_TYPE_DB_MONITOR, ITEM_TYPE_CALCULATED, ITEM_TYPE_DEPENDENT, ITEM_TYPE_SCRIPT
											]);
									}, 'type' => API_ID, 'flags' => API_REQUIRED],
									['if' => ['field' => 'host_status', 'in' => implode(',', [HOST_STATUS_MONITORED, HOST_STATUS_NOT_MONITORED])], 'type' => API_ID],
									['else' => true, 'type' => API_UNEXPECTED]
			]]
		];
	}

	/**
	 * @inheritDoc
	 */
	public static function getUpdateValidationRulesInherited(array &$item, array $db_item): array {
		return [
			'interfaceid' =>	['type' => API_MULTIPLE, 'rules' => [
									['if' => static function () use ($db_item): bool {
										return in_array($db_item['host_status'], [HOST_STATUS_MONITORED, HOST_STATUS_NOT_MONITORED]);
									}, 'type' => API_ID],
									['else' => true, 'type' => API_UNEXPECTED]
			]]
		];
	}

	/**
	 * @inheritDoc
	 */
	public static function getUpdateValidationRulesDiscovered(array &$item, array $db_item): array {
		return [
			'interfaceid' =>	['type' => API_UNEXPECTED, 'error_type' => API_ERR_DISCOVERED]
		];
	}
}
