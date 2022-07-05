DROP TABLE IF EXISTS `work_experience_details`;
DROP TABLE IF EXISTS `work_experience`;
DROP TABLE IF EXISTS `education`;
DROP TABLE IF EXISTS `technical_skills`;
DROP TABLE IF EXISTS `styles`;
DROP TABLE IF EXISTS `contacts`;

CREATE TABLE IF NOT EXISTS `contacts` (
    `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `first_name` VARCHAR(50) DEFAULT '',
    `last_name` VARCHAR(50) DEFAULT '',
    `email` VARCHAR(50) DEFAULT '',
    `city` VARCHAR(50) DEFAULT '',
    `province` VARCHAR(50) DEFAULT '',
    `phone` VARCHAR(50) DEFAULT '',
    `github` VARCHAR(50) DEFAULT '',
    `description` TEXT,
    `created` TIMESTAMP NOT NULL DEFAULT now(),
    `modified` TIMESTAMP NOT NULL DEFAULT now() ON UPDATE now()
);

CREATE TABLE IF NOT EXISTS `styles` (
    `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `contact_id` int NOT NULL,
    `color` VARCHAR(50) DEFAULT '',
    `created` TIMESTAMP NOT NULL DEFAULT now(),
    `modified` TIMESTAMP NOT NULL DEFAULT now() ON UPDATE now(),
    FOREIGN KEY (contact_id) REFERENCES contacts(id)
);

CREATE TABLE IF NOT EXISTS `technical_skills` (
    `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `contact_id` int NOT NULL,
    `name` VARCHAR(50) DEFAULT '',
    `value` TINYINT DEFAULT 0,
    `created` TIMESTAMP NOT NULL DEFAULT now(),
    `modified` TIMESTAMP NOT NULL DEFAULT now() ON UPDATE now(),
    FOREIGN KEY (contact_id) REFERENCES contacts(id)
);

CREATE TABLE IF NOT EXISTS `education` (
    `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `contact_id` int NOT NULL,
    `start_year` int NOT NULL,
    `end_year` int NOT NULL,
    `course_name` VARCHAR(50) DEFAULT '',
    `school_name` VARCHAR(50) DEFAULT '',
    `school_city` VARCHAR(50) DEFAULT '',
    `school_province` VARCHAR(50) DEFAULT '',
    `created` TIMESTAMP NOT NULL DEFAULT now(),
    `modified` TIMESTAMP NOT NULL DEFAULT now() ON UPDATE now(),
    FOREIGN KEY (contact_id) REFERENCES contacts(id)
);

CREATE TABLE IF NOT EXISTS `work_experience` (
    `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `contact_id` int NOT NULL,
    `job_title` VARCHAR(50) DEFAULT '',
    `start_year` int NOT NULL,
    `end_year` int NOT NULL,
    `company_name` VARCHAR(50) DEFAULT '',
    `company_city` VARCHAR(50) DEFAULT '',
    `company_province` VARCHAR(50) DEFAULT '',
    `created` TIMESTAMP NOT NULL DEFAULT now(),
    `modified` TIMESTAMP NOT NULL DEFAULT now() ON UPDATE now(),
    FOREIGN KEY (contact_id) REFERENCES contacts(id)
);

CREATE TABLE IF NOT EXISTS `work_experience_details` (
    `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `work_experience_id` int NOT NULL,
    `description` TEXT,
    `created` TIMESTAMP NOT NULL DEFAULT now(),
    `modified` TIMESTAMP NOT NULL DEFAULT now() ON UPDATE now(),
    FOREIGN KEY (work_experience_id) REFERENCES work_experience(id)
);

INSERT INTO contacts (first_name, last_name, email, city, province, phone, github, description) VALUES(
    'Isaac',
    'Barnard',
    'ibarnard89@gmail.com',
    'St. Catharines',
    'ON',
    '(289) 786-0486',
    'github.com/isaacbarnard',
    'Programmer skilled at technical leadership, communication and presentation. Experienced in full project life cycle from discovery and design to development implementation and maintenance. Able to develop full-stack web applications upon multiple frameworks from a host of design philosophies. Client facing experience discussing scope of work, deliverables and milestones appropriate to the end users specific needs.'
),(
    'Bob',
    'Marley',
    'bmarley@gmail.com',
    'Toronto',
    'ON',
    '(289) 888-8888',
    'https://github.com/bmarley',
    'Famouse singer / songwriter.'
),(
    'Lucille',
    'Ball',
    'lball@gmail.com',
    'Los Angeles',
    'CA',
    '(555) 555-5555',
    'https://github.com/lball',
    'Famouse actor.'
);

INSERT INTO styles (contact_id, color) VALUES
(1,'#2860cd');

INSERT INTO technical_skills (contact_id, name, value) VALUES
(1, 'PHP', 5),
(1, 'HTML5', 5),
(1, 'JS', 4),
(1, 'CSS3', 5),
(1, 'JQuery', 3),
(1, 'SQL', 4),
(1, 'C#', 5),
(1, 'Java', 5),
(1, 'WS', 4),
(1, 'Linux', 5);

INSERT INTO education (contact_id, course_name, school_name, school_city, school_province, start_year, end_year) VALUES(
    1,
    'Computer Systems Technology - Software Development',
    'Mohawk College',
    'Hamilton',
    'ON',
    2012,
    2014
);

INSERT INTO work_experience (contact_id, job_title, company_name, company_city, company_province, start_year, end_year) VALUES(
    1,
    'IT support specialist',
    'Aatel Communications Inc.',
    'Hamilton',
    'ON',
    2013,
    2013
),(
    1,
    'Senior Programmer',
    'OTP Design-Works',
    'Hamilton',
    'ON',
    2014,
    2021
);

INSERT INTO work_experience_details (work_experience_id, description) VALUES(
    1,
    'Provided IT support services, troubleshooting and system administration/operation.'
),(
    1,
    'Provided introductory training and support on new hardware and software to employees.'
),(
    1,
    'Used monitoring applications and workflows to provide performance statistics and reports.'
),(
    1,
    'Set up global and local video conferencing, webex, zoom and audio dial-ins for end-users and clients.'
),(
    1,
    'Image, re-image, build and configure new/used company laptops and desktops.'
),(
    1,
    'Developed and deployed an Outlook add-on to synchronize employee contacts from their local machine to the company CRM.'
);

INSERT INTO work_experience_details (work_experience_id, description) VALUES(
    2,
    'Lead discovery meetings with potential clients to ensure that expectations were adequately set to guarantee that projects would run smoothly and within scope.'
),(
    2,
    'Properly define and itemize deliverables within a scope of work to meet client expectations while within the boundaries of company/employee capabilities.'
),(
    2,
    'Onboarded and trained client employees in the applications or services provided from a given project or its third-party dependencies.'
),(
    2,
    'Perform development and integration testing to ensure project related enhancement/refactoring is deployed accurately and efficiently.'
),(
    2,
    'Developed embedded solutions for third-party cloud based CRM, ERP or POS systems when the underlying software did not satisfy a client\'s needs.'
),(
    2,
    'Developed bridging software to maintain data integrity between a client\'s old business solution and the newly developed one while they train/migrate their users.'
),(
    2,
    'Developed multiple fleet management systems with unique client requirements not met by standard software.'
);
