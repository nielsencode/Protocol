SELECT
supplements.name AS `supplement name`,
clients.first_name AS `client first name`,
clients.last_name AS `client last name`
FROM protocols
JOIN supplements
ON supplements.id = protocols.sup_id
JOIN clients
ON clients.id = protocols.client_id