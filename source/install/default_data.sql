USE xshopy;

-- root user
INSERT INTO `user` (name, password, type, create_time) 
            VALUES ('root', md5('root'), 'SuperAdmin', NOW()) 
                ON DUPLICATE KEY UPDATE name=name;
