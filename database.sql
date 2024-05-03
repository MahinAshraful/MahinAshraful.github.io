CREATE TABLE userinfo(
    emplid VARCHAR(50),
    fName VARCHAR(15),
    lName VARCHAR(15),
    pass varchar(20),
    position VARCHAR(15),
    PRIMARY KEY (emplid));

CREATE TABLE notes (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    description VARCHAR(255) NOT NULL,
    due_date DATE NOT NULL
);