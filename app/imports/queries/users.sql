SELECT
clients.first_name AS `first name`,
clients.last_name AS `last name`,
users.email AS email,
clients.email AS `client email`
FROM users
JOIN user_client
ON user_client.user_id = users.id
JOIN clients
ON user_client.client_id = clients.id