SELECT
supplements.name AS `supplement name`,
clients.email AS `client email`
FROM protocols
JOIN supplements
ON supplements.id = protocols.sup_id
JOIN clients
ON clients.id = protocols.client_id