SELECT *
FROM (
	SELECT
	clients.first_name AS `client first name`,
	clients.last_name AS `client last name`,
	supplements.name AS `supplement name`,
	autoship.quant AS `quantity`,
	DATE_ADD(
		DATE_FORMAT(autoship.date_created,'%Y-%m-%date'),
		INTERVAL CEIL(
			DATEDIFF(
				CURDATE(),
				DATE_FORMAT(autoship.date_created,'%Y-%m-%date')
			)
			/autoship.freq
		)
		*autoship.freq DAY
	) AS `date`,
	CONCAT(autoship.freq,' days') AS `frequency`
	FROM autoship
	JOIN protocols
	ON protocols.id = autoship.protocol_id
	JOIN clients
	ON clients.id = protocols.client_id
	JOIN supplements
	ON supplements.id = protocols.sup_id
) orders
ORDER BY date ASC