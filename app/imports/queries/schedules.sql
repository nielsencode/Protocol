SELECT
supplements.name AS `supplement name`,
clients.email AS `client email`,
prescription,
times_of_day.description AS `scheduletime name`
FROM schedules
JOIN protocols
ON schedules.protocol_id = protocols.id
JOIN supplements
ON supplements.id = protocols.sup_id
JOIN clients
ON clients.id = protocols.client_id
JOIN times_of_day
ON times_of_day.id = schedules.time_id