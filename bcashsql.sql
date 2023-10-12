-- Create tbl_ActorCategory
CREATE TABLE tbl_ActorCategory (
    ActorCategory_Id INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(255) NOT NULL
);

-- Create tbl_Course
CREATE TABLE tbl_Course (
    Course_Id INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(255) NOT NULL,
    Abbreviation VARCHAR(20) NULL
);

-- Create tbl_Department
CREATE TABLE tbl_Department (
    Department_Id INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(255) NOT NULL,
    Abbreviation VARCHAR(20) NULL
);

-- Create tbl_Group
CREATE TABLE tbl_Group (
    Group_Id INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(255) NOT NULL
);

-- Create tbl_Campus
CREATE TABLE tbl_Campus (
    Campus_Id INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(255) NOT NULL,
    Abbreviation VARCHAR(20) NULL
);

-- Create tbl_UsersData
CREATE TABLE tbl_UsersData (
    UsersAccount_Address VARCHAR(15) PRIMARY KEY,
    GuardianAccount_Address VARCHAR(15) NULL,
    Group_Id INT NULL,
    Department_Id INT NULL,
    Course_Id INT NULL,
    Campus_Id INT NULL,
    SchoolPersonalId VARCHAR(15) NULL,
    Balance FLOAT DEFAULT 0,
    YearLevel VARCHAR(10) NULL,
    CanDoTransfers BIT DEFAULT 1,
    CanDoTransactions BIT DEFAULT 1,
    CanUseCard BIT DEFAULT 1,
    CanModifySettings BIT DEFAULT 1,
    IsPurchaseAutoConfirm BIT DEFAULT 0,
    IsParentalActive BIT DEFAULT 0
);

-- Create tbl_UsersAccount
CREATE TABLE tbl_UsersAccount (
    UsersAccount_Address VARCHAR(15) PRIMARY KEY,
    ActorCategory_Id INT,
    Email VARCHAR(50) NULL,
    EmailId VARCHAR(50) NULL,
    Firstname VARCHAR(50) NOT NULL,
    Lastname VARCHAR(50) NOT NULL,
    PinCode VARCHAR(6) NULL,
    IsAccountActive BIT DEFAULT 1,
    LastSeen TIMESTAMP NULL
);

-- Create tbl_GuardianAccount
CREATE TABLE tbl_GuardianAccount (
    GuardianAccount_Address VARCHAR(15) PRIMARY KEY,
    UsersAccount_Address VARCHAR(15) NOT NULL,
    ActorCategory_Id INT NOT NULL,
    Email VARCHAR(50) NOT NULL,
    EmailId VARCHAR(25) NOT NULL,
    Firstname VARCHAR(50) NOT NULL,
    Lastname VARCHAR(50) NOT NULL,
    PinCode VARCHAR(6) NULL,
    IsAccountActive BIT DEFAULT 1
);

-- Create tbl_WebAccounts
CREATE TABLE tbl_WebAccounts (
    WebAccounts_Address VARCHAR(15) PRIMARY KEY,
    ActorCategory_Id INT NOT NULL,
    Username VARCHAR(50) NOT NULL,
    Password VARCHAR(255) NOT NULL,
    Email VARCHAR(50) NOT NULL,
    Firstname VARCHAR(50) NOT NULL,
    Lastname VARCHAR(50) NOT NULL,
    PinCode VARCHAR(6) NULL,
    IsAccountActive BIT DEFAULT 1,
    LastSeen TIMESTAMP NULL
);

-- Create tbl_Notifications
CREATE TABLE tbl_Notifications (
    Notification_ID INT AUTO_INCREMENT PRIMARY KEY,
    Creator_Account_Address VARCHAR(15) NOT NULL,
    Level VARCHAR(10) NOT NULL,
    Title VARCHAR(255) NOT NULL,
    Content TEXT NOT NULL,
    IsNew BIT DEFAULT 1
);

-- Create tbl_Authentications
CREATE TABLE tbl_Authentications (
    Account_Address VARCHAR(15) PRIMARY KEY,
    AuthToken VARCHAR(30) NULL,
    AuthExpirationTime TIMESTAMP NULL,
    AuthCreationTime TIMESTAMP NULL,
    OtpCode VARCHAR(6) NULL,
    OtpCreationTime TIMESTAMP NULL,
    OtpExpirationTime TIMESTAMP NULL,
    IpAddress VARCHAR(20) NOT NULL,
    Location VARCHAR(50) NOT NULL,
    Device VARCHAR(50) NOT NULL,
    IsOnline BIT DEFAULT 0
);

-- Create tbl_LoginHistory
CREATE TABLE tbl_LoginHistory (
    Account_Address VARCHAR(15) PRIMARY KEY,
    IpAddress VARCHAR(20) NOT NULL,
    IsBlocked BIT DEFAULT 0,
    Location VARCHAR(50) NOT NULL,
    Device VARCHAR(50) NOT NULL,
    LastOnline TIMESTAMP NULL
);

-- Create tbl_ActivityLogs
CREATE TABLE tbl_ActivityLogs (
    ActivityLogs_Id INT AUTO_INCREMENT PRIMARY KEY,
    Account_Address VARCHAR(15) NOT NULL,
    Task VARCHAR(255) NOT NULL,
    Timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create tbl_MerchantsCategory
CREATE TABLE tbl_MerchantsCategory (
    MerchantsCategory_Id INT AUTO_INCREMENT PRIMARY KEY,
    Campus_Id INT NOT NULL,
    ShopName VARCHAR(255) NOT NULL
);

-- Create tbl_Merchants
CREATE TABLE tbl_Merchants (
    WebAccounts_Address VARCHAR(15) PRIMARY KEY,
    MerchantsCategory_Id INT NOT NULL
);

-- Create tbl_ItemsCategory
CREATE TABLE tbl_ItemsCategory (
    ItemsCategory_Id INT AUTO_INCREMENT PRIMARY KEY,
    MerchantsCategory_Id INT NOT NULL,
    Name VARCHAR(255) NOT NULL
);

-- Create tbl_MerchantItems
CREATE TABLE tbl_MerchantItems (
    MerchantItems_Id INT AUTO_INCREMENT PRIMARY KEY,
    ItemsCategory_Id INT NOT NULL,
    MerchantsCategory_Id INT NOT NULL,
    Name VARCHAR(50) NOT NULL,
    Price FLOAT NOT NULL,
    Image VARCHAR(255) NULL,
    IsActive BIT DEFAULT 1,
    CreatedTimestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    ModifiedTimestamp TIMESTAMP NULL
);

-- Create tbl_TransactionType
CREATE TABLE tbl_TransactionType (
    TransactionType_Id INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(255) NOT NULL
);

-- Create tbl_TransactionItems
CREATE TABLE tbl_TransactionItems (
    Transaction_Address VARCHAR(20) PRIMARY KEY,
    MerchantItems_Id INT NOT NULL,
    Quantity INT NOT NULL,
    Amount FLOAT NOT NULL
);

-- Create tbl_TransactionsInfo
CREATE TABLE tbl_TransactionsInfo (
    Transaction_Address VARCHAR(20) PRIMARY KEY,
    TransactionType_Id INT NOT NULL,
    Sender_Address VARCHAR(15) NOT NULL,
    Receiver_Address VARCHAR(15) NOT NULL,
    Status VARCHAR(50) NOT NULL,
    Amount FLOAT NOT NULL,
    Discount FLOAT NOT NULL,
    DiscountReason VARCHAR(255) NULL,
    TotalAmount FLOAT NOT NULL,
    PostedBy VARCHAR(15) NOT NULL,
    Message VARCHAR(255) NULL,
    Timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create tbl_Transactions
CREATE TABLE tbl_Transactions (
    Transaction_Address VARCHAR(20) PRIMARY KEY,
    Account_Address VARCHAR(15) NOT NULL,
    Status VARCHAR(50) NOT NULL,
    Debit FLOAT NOT NULL,
    Credit FLOAT NOT NULL,
    Timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create tbl_Configurations
CREATE TABLE tbl_Configurations (
    Configuration_Id INT AUTO_INCREMENT PRIMARY KEY,
    Title VARCHAR(100) NOT NULL,
    Value VARCHAR(100) NOT NULL,
    Description TEXT NULL
);

-- Create tbl_Whitelist
CREATE TABLE tbl_Whitelist (
    Account_Address VARCHAR(15) PRIMARY KEY,
    Whitelisted_Address VARCHAR(15) NOT NULL,
    Timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Add foreign key constraints
ALTER TABLE tbl_UsersData
    ADD FOREIGN KEY (GuardianAccount_Address) REFERENCES tbl_GuardianAccount(GuardianAccount_Address),
    ADD FOREIGN KEY (Group_Id) REFERENCES tbl_Group(Group_Id),
    ADD FOREIGN KEY (Department_Id) REFERENCES tbl_Department(Department_Id),
    ADD FOREIGN KEY (Course_Id) REFERENCES tbl_Course(Course_Id),
    ADD FOREIGN KEY (Campus_Id) REFERENCES tbl_Campus(Campus_Id);

ALTER TABLE tbl_GuardianAccount
    ADD FOREIGN KEY (UsersAccount_Address) REFERENCES tbl_UsersData(UsersAccount_Address),
    ADD FOREIGN KEY (ActorCategory_Id) REFERENCES tbl_ActorCategory(ActorCategory_Id);

ALTER TABLE tbl_WebAccounts
    ADD FOREIGN KEY (ActorCategory_Id) REFERENCES tbl_ActorCategory(ActorCategory_Id);

ALTER TABLE tbl_Notifications
    ADD FOREIGN KEY (Creator_Account_Address) REFERENCES tbl_WebAccounts(WebAccounts_Address);

ALTER TABLE tbl_TransactionItems
    ADD FOREIGN KEY (MerchantItems_Id) REFERENCES tbl_MerchantItems(MerchantItems_Id);

ALTER TABLE tbl_TransactionsInfo
    ADD FOREIGN KEY (TransactionType_Id) REFERENCES tbl_TransactionType(TransactionType_Id);

ALTER TABLE tbl_merchantscategory 
    ADD FOREIGN KEY (Campus_Id) REFERENCES tbl_campus(Campus_Id);

ALTER TABLE tbl_merchants 
	ADD FOREIGN KEY (WebAccounts_Address) REFERENCES tbl_webaccounts(WebAccounts_Address);
    
ALTER TABLE tbl_merchants 
	ADD FOREIGN KEY (MerchantsCategory_Id) REFERENCES tbl_merchantscategory(MerchantsCategory_Id);

CREATE UNIQUE INDEX unique_loginhistory
ON tbl_loginhistory (Account_Address, IpAddress, Location, Device);

-- Set FOREIGN_KEY_CHECKS back to 1 to enable foreign key constraints
SET FOREIGN_KEY_CHECKS = 1;


DROP TABLE IF EXISTS tbl_UsersData;
DROP TABLE IF EXISTS tbl_Course;
DROP TABLE IF EXISTS tbl_Department;
DROP TABLE IF EXISTS tbl_Group;
DROP TABLE IF EXISTS tbl_GuardianAccount;
DROP TABLE IF EXISTS tbl_ActorCategory;
DROP TABLE IF EXISTS tbl_Notifications;
DROP TABLE IF EXISTS tbl_Authentications;
DROP TABLE IF EXISTS tbl_LoginHistory;
DROP TABLE IF EXISTS tbl_WebAccounts;
DROP TABLE IF EXISTS tbl_ActivityLogs;
DROP TABLE IF EXISTS tbl_Merchants;
DROP TABLE IF EXISTS tbl_MerchantsCategory;
DROP TABLE IF EXISTS tbl_ItemsCategory;
DROP TABLE IF EXISTS tbl_MerchantItems;
DROP TABLE IF EXISTS tbl_TransactionType;
DROP TABLE IF EXISTS tbl_TransactionItems;
DROP TABLE IF EXISTS tbl_TransactionsInfo;
DROP TABLE IF EXISTS tbl_Transactions;
DROP TABLE IF EXISTS tbl_Configurations;
DROP TABLE IF EXISTS tbl_Campus;
DROP TABLE IF EXISTS tbl_Whitelist;


INSERT INTO `tbl_actorcategory`(`Name`) VALUES ('Administrator');
INSERT INTO `tbl_actorcategory`(`Name`) VALUES ('Accounting');
INSERT INTO `tbl_actorcategory`(`Name`) VALUES ('MerchantAdmin');
INSERT INTO `tbl_actorcategory`(`Name`) VALUES ('MerchantStaff');

INSERT INTO `tbl_webaccounts` (`WebAccounts_Address`, `ActorCategory_Id`, `Username`, `Password`, `Email`, `Firstname`, `Lastname`, `PinCode`, `IsAccountActive`, `LastSeen`) VALUES ('ADM000000000000', '1', 'administrator', '12345', 'jameslayson.0@gmail.com', 'admin', 'admin', NULL, b'1', NULL);

INSERT INTO `tbl_webaccounts` (`WebAccounts_Address`, `ActorCategory_Id`, `Username`, `Password`, `Email`, `Firstname`, `Lastname`, `PinCode`, `IsAccountActive`, `LastSeen`) VALUES ('ACT000000000000', '2', 'accounting', '12345', 'jameslayson.0@gmail.com', 'accounting', 'accounting', NULL, b'1', NULL);

INSERT INTO `tbl_webaccounts` (`WebAccounts_Address`, `ActorCategory_Id`, `Username`, `Password`, `Email`, `Firstname`, `Lastname`, `PinCode`, `IsAccountActive`, `LastSeen`) VALUES ('MTS000000000000', '4', 'MerchantStaff', '12345', 'jameslayson.0@gmail.com', 'MerchantStaff', 'MerchantStaff', NULL, b'1', NULL);

INSERT INTO `tbl_webaccounts` (`WebAccounts_Address`, `ActorCategory_Id`, `Username`, `Password`, `Email`, `Firstname`, `Lastname`, `PinCode`, `IsAccountActive`, `LastSeen`) VALUES ('MTA000000000000', '3', 'MerchantAdmin', '12345', 'jameslayson.0@gmail.com', 'MerchantAdmin', 'MerchantAdmin', NULL, b'1', NULL);







