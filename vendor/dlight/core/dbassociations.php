<?
// https://www.doctrine-project.org/projects/doctrine-orm/en/2.9/reference/association-mapping.html#one-to-one-unidirectional

class Association {
function Create_ManyToOne ($owner, $reference) {
    // Reference, Catalogue
    // Many-To-One, Unidirectional
    // A many-to-one association is the most common association between objects. Example: Many Users have One Address:

    $sqlBase = "
    CREATE TABLE User (
        id INT AUTO_INCREMENT NOT NULL,
        address_id INT DEFAULT NULL,
        PRIMARY KEY(id)
    ) ENGINE = InnoDB;
    
    CREATE TABLE Address (
        id INT AUTO_INCREMENT NOT NULL,
        PRIMARY KEY(id)
    ) ENGINE = InnoDB;
    ";

    $sqlActive = "
    ALTER TABLE {$owner} ADD FOREIGN KEY ({$reference}_id) REFERENCES {$reference}(id);
    ";
}
function Create_OneToOneUni ($owner, $reference) {
// One-To-One, Unidirectional
// Here is an example of a one-to-one association with a Product entity that references one Shipment entity.
// UNIQUE INDEX UNIQ_6FBC94267FE4B2B (shipment_id),

    $sqlBase = "
    CREATE TABLE Product (
        id INT AUTO_INCREMENT NOT NULL,
        shipment_id INT DEFAULT NULL,
        UNIQUE INDEX UNIQ_6FBC94267FE4B2B (shipment_id),
        PRIMARY KEY(id)
    ) ENGINE = InnoDB;
    CREATE TABLE Shipment (
        id INT AUTO_INCREMENT NOT NULL,
        PRIMARY KEY(id)
    ) ENGINE = InnoDB;
    ";

    $sqlActive = "
    ALTER TABLE {$owner} ADD FOREIGN KEY ({$reference}_id) REFERENCES {$reference}(id);
    ";

}    

function Create_OneToOneBi ($owner, $reference) {
    // One-To-One, Bidirectional
    // Here is a one-to-one relationship between a Customer and a Cart. The Cart has a reference back to the Customer so it is bidirectional.
    // I can't see difference
    // $owner = 'cart', $reference = 'customer'
        $sqlBase = "
        CREATE TABLE Cart (
            id INT AUTO_INCREMENT NOT NULL,
            customer_id INT DEFAULT NULL,
            PRIMARY KEY(id)
        ) ENGINE = InnoDB;
        CREATE TABLE Customer (
            id INT AUTO_INCREMENT NOT NULL,
            PRIMARY KEY(id)
        ) ENGINE = InnoDB;
        ";
    
        // ALTER TABLE Cart ADD FOREIGN KEY (customer_id) REFERENCES Customer(id);
        $sqlActive = "
        ALTER TABLE {$owner} ADD FOREIGN KEY ({$reference}_id) REFERENCES {$reference}(id);
        ";
    }    
function Create_OneToOneSelf ($owner, $reference) {
    // One-To-One, Self-referencing
    // You can define a self-referencing one-to-one relationships
    // One Student has One Mentor.
    // ???
    // $owner = 'Student', $reference = 'mentor'
        $sqlBase = "
        CREATE TABLE Student (
            id INT AUTO_INCREMENT NOT NULL,
            mentor_id INT DEFAULT NULL,
            PRIMARY KEY(id)
        ) ENGINE = InnoDB;
        ";
    
        // ALTER TABLE Student ADD FOREIGN KEY (mentor_id) REFERENCES Student(id);
        $sqlActive = "
        ALTER TABLE {$owner} ADD FOREIGN KEY ({$reference}_id) REFERENCES {$owner}(id);
        ";
    }    
function Create_OneToManyBi ($owner, $reference) {
    // One-To-Many, Bidirectional    
    // This means there is no difference between a bidirectional one-to-many and a bidirectional many-to-one.
    // One product has many features. This is the inverse side.
    // @OneToMany(targetEntity="Feature", mappedBy="product")
    // ???
    // $owner = 'Product', $reference = 'Feature'
        $sqlBase = "
        CREATE TABLE Product (
            id INT AUTO_INCREMENT NOT NULL,
            PRIMARY KEY(id)
        ) ENGINE = InnoDB;
        CREATE TABLE Feature (
            id INT AUTO_INCREMENT NOT NULL,
            product_id INT DEFAULT NULL,
            PRIMARY KEY(id)
        ) ENGINE = InnoDB;        ";
    
        // ALTER TABLE Feature ADD FOREIGN KEY (product_id) REFERENCES Product(id);
        $sqlActive = "
        ALTER TABLE {$reference} ADD FOREIGN KEY ({$owner}_id) REFERENCES {$owner}(id);
        ";
    }    
function Create_OneToManyUniJoin ($owner, $reference) {
    // One-To-Many, Unidirectional with Join Table
    // A unidirectional one-to-many association can be mapped through a join table. From Doctrine's point of view, it is simply mapped as a unidirectional many-to-many whereby a unique constraint on one of the join columns enforces the one-to-many cardinality.   
// owner = 'user', reference = phonenumbers
        $sqlBase = "
        CREATE TABLE User (
            id INT AUTO_INCREMENT NOT NULL,
            PRIMARY KEY(id)
        ) ENGINE = InnoDB;
        
        CREATE TABLE users_phonenumbers (
            user_id INT NOT NULL,
            phonenumber_id INT NOT NULL,
            UNIQUE INDEX users_phonenumbers_phonenumber_id_uniq (phonenumber_id),
            PRIMARY KEY(user_id, phonenumber_id)
        ) ENGINE = InnoDB;
        
        CREATE TABLE Phonenumber (
            id INT AUTO_INCREMENT NOT NULL,
            PRIMARY KEY(id)
        ) ENGINE = InnoDB;
        
        ALTER TABLE users_phonenumbers ADD FOREIGN KEY (user_id) REFERENCES User(id);
        ALTER TABLE users_phonenumbers ADD FOREIGN KEY (phonenumber_id) REFERENCES Phonenumber(id);
        ";
    
        $sqlActive = 
"
ALTER TABLE {$owner}_{$reference} ADD FOREIGN KEY ({$owner}_id) REFERENCES {$owner}(id);
ALTER TABLE {$owner}_{$reference} ADD FOREIGN KEY ({$reference}_id) REFERENCES {$reference}(id);
";
    }    
function Create_OneToManySelf ($owner, $reference) {
    // One-To-Many, Self-referencing
    // You can also setup a one-to-many association that is self-referencing. In this example we setup a hierarchy of Category objects by creating a self referencing relationship. This effectively models a hierarchy of categories and from the database perspective is known as an adjacency list approach.
// owner = 'user', reference = phonenumbers
        $sqlBase = "
        CREATE TABLE Category (
            id INT AUTO_INCREMENT NOT NULL,
            parent_id INT DEFAULT NULL,
            PRIMARY KEY(id)
        ) ENGINE = InnoDB;
        ALTER TABLE Category ADD FOREIGN KEY (parent_id) REFERENCES Category(id);
        ";
    
        $sqlActive = 
"
ALTER TABLE Category ADD FOREIGN KEY (parent_id) REFERENCES Category(id);
";
    }    

    function Create_ManyToMany ($owner1, $owner2) {
        // Many-To-Many, Unidirectional
        // Real many-to-many associations are less common. The following example shows a unidirectional association between User and Group entities:

        $sqlBase = "
        CREATE TABLE User (
            id INT AUTO_INCREMENT NOT NULL,
            PRIMARY KEY(id)
        ) ENGINE = InnoDB;
        CREATE TABLE users_groups (
            user_id INT NOT NULL,
            group_id INT NOT NULL,
            PRIMARY KEY(user_id, group_id)
        ) ENGINE = InnoDB;
        CREATE TABLE Group (
            id INT AUTO_INCREMENT NOT NULL,
            PRIMARY KEY(id)
        ) ENGINE = InnoDB;
        ALTER TABLE users_groups ADD FOREIGN KEY (user_id) REFERENCES User(id);
        ALTER TABLE users_groups ADD FOREIGN KEY (group_id) REFERENCES Group(id);
        ";
        
            $sqlActive = 
    "
    ALTER TABLE {$owner1}_{$owner2} ADD FOREIGN KEY ({$owner1}_id) REFERENCES {$owner1}(id);
    ALTER TABLE {$owner1}_{$owner2} ADD FOREIGN KEY ({$owner2}_id) REFERENCES {$owner2}(id);
    ";
        }    


}