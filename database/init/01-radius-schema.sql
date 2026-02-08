-- FreeRADIUS Database Schema
-- This creates the necessary tables for RADIUS authentication and accounting

-- Create database if it doesn't exist
CREATE DATABASE IF NOT EXISTS radius;
USE radius;

-- User authentication table
CREATE TABLE IF NOT EXISTS radcheck (
    id int(11) unsigned NOT NULL auto_increment,
    username varchar(64) NOT NULL default '',
    attribute varchar(64) NOT NULL default '',
    op varchar(2) NOT NULL default '==',
    value varchar(253) NOT NULL default '',
    PRIMARY KEY (id),
    KEY username (username)
) ENGINE=InnoDB;

-- User group assignments
CREATE TABLE IF NOT EXISTS radusergroup (
    username varchar(64) NOT NULL default '',
    groupname varchar(64) NOT NULL default '',
    priority int(11) NOT NULL default '1',
    PRIMARY KEY (username, groupname, priority)
) ENGINE=InnoDB;

-- Group check attributes
CREATE TABLE IF NOT EXISTS radgroupcheck (
    id int(11) unsigned NOT NULL auto_increment,
    groupname varchar(64) NOT NULL default '',
    attribute varchar(64) NOT NULL default '',
    op varchar(2) NOT NULL default '==',
    value varchar(253) NOT NULL default '',
    PRIMARY KEY (id),
    KEY groupname (groupname)
) ENGINE=InnoDB;

-- Group reply attributes
CREATE TABLE IF NOT EXISTS radgroupreply (
    id int(11) unsigned NOT NULL auto_increment,
    groupname varchar(64) NOT NULL default '',
    attribute varchar(64) NOT NULL default '',
    op varchar(2) NOT NULL default '=',
    value varchar(253) NOT NULL default '',
    PRIMARY KEY (id),
    KEY groupname (groupname)
) ENGINE=InnoDB;

-- Accounting table
CREATE TABLE IF NOT EXISTS radacct (
    radacctid bigint(21) NOT NULL auto_increment,
    acctsessionid varchar(64) NOT NULL default '',
    acctuniqueid varchar(32) NOT NULL default '',
    username varchar(64) NOT NULL default '',
    groupname varchar(64) NOT NULL default '',
    realm varchar(64) default '',
    nasipaddress varchar(15) NOT NULL default '',
    nasportid varchar(15) default NULL,
    nasporttype varchar(32) default NULL,
    acctstarttime datetime NULL default NULL,
    acctstoptime datetime NULL default NULL,
    acctsessiontime int(12) unsigned default NULL,
    acctauthentic varchar(32) default NULL,
    connectinfo_start varchar(50) default NULL,
    connectinfo_stop varchar(50) default NULL,
    acctinputoctets bigint(20) default NULL,
    acctoutputoctets bigint(20) default NULL,
    calledstationid varchar(50) NOT NULL default '',
    callingstationid varchar(50) NOT NULL default '',
    acctterminatecause varchar(32) NOT NULL default '',
    servicetype varchar(32) default NULL,
    framedprotocol varchar(32) default NULL,
    framedipaddress varchar(15) NOT NULL default '',
    PRIMARY KEY (radacctid),
    KEY username (username),
    KEY framedipaddress (framedipaddress),
    KEY acctsessionid (acctsessionid),
    KEY acctsessiontime (acctsessiontime),
    KEY acctuniqueid (acctuniqueid),
    KEY nasipaddress (nasipaddress),
    KEY acctstarttime (acctstarttime),
    KEY acctstoptime (acctstoptime)
) ENGINE=InnoDB;

-- Post-authentication logging
CREATE TABLE IF NOT EXISTS radpostauth (
    id int(11) NOT NULL auto_increment,
    username varchar(64) NOT NULL default '',
    pass varchar(64) NOT NULL default '',
    reply varchar(32) NOT NULL default '',
    authdate timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
) ENGINE=InnoDB;

-- Insert default group for hotspot users
INSERT INTO radgroupreply (groupname, attribute, op, value) VALUES 
('hotspot_users', 'Session-Timeout', '=', '3600'),
('hotspot_users', 'Idle-Timeout', '=', '600'),
('hotspot_users', 'Framed-Protocol', '=', 'PPP'),
('hotspot_users', 'Service-Type', '=', 'Framed-User');

-- Create a test user (password: test123)
INSERT INTO radcheck (username, attribute, op, value) VALUES 
('testuser', 'Cleartext-Password', ':=', 'test123'),
('testuser', 'Auth-Type', ':=', 'Local');

-- Assign test user to hotspot group
INSERT INTO radusergroup (username, groupname, priority) VALUES 
('testuser', 'hotspot_users', 1);
