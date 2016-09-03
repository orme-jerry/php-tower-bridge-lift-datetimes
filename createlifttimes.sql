CREATE TABLE IF NOT EXISTS `lifttimes` (
  `auto_id` int(11) NOT NULL,
  `currentdatetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `datetime` datetime NOT NULL,
  `vessel` varchar(255) NOT NULL,
  `direction` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `lifttimes`
  ADD PRIMARY KEY (`auto_id`),
  ADD UNIQUE KEY `uq_lifttimes` (`datetime`,`vessel`,`direction`);

ALTER TABLE `lifttimes`
  MODIFY `auto_id` int(11) NOT NULL AUTO_INCREMENT;
