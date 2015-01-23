SELECT
clients.first_name AS `first name`,
clients.last_name AS `last name`,
users.email AS email,
clients.first_name AS `client first name`,
clients.last_name AS `client last name`
FROM users
JOIN user_client
ON user_client.user_id = users.id
JOIN clients
ON user_client.client_id = clients.id