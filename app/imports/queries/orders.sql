SELECT
clients.email AS `client email`,
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
) AS `date`
FROM autoship
JOIN protocols
ON protocols.id = autoship.protocol_id
JOIN clients
ON clients.id = protocols.client_id
JOIN supplements
ON supplements.id = protocols.sup_id