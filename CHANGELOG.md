# Change Log

All notable changes to this project will be documented in this file. This project adheres
to [Semantic Versioning] (http://semver.org/). For change log format,
use [Keep a Changelog] (http://keepachangelog.com/).

## [1.2.0] - 2022-03-17

### Added

- PHP 8.0 and PHP 8.1 support
- Define SOAP Extension into composer requirements
- Define JSON Extension into composer requirements
- Define DOM Extension into composer suggests

### Changed

- Method `AbstractObject::__set_state()` renamed to `AbstractObject::getArrayCopy()`
- Code style

## [1.1.1] - 2022-03-17

### Fixed

- Pull request @jbrissonnet-vp: Fix JSESSIONID regexp

## [1.1.0] - 2019-09-16

### Changed

- Pull request @jcarrier-vp: Allow to pass SoapClient options in the constructor

## [1.0.0] - 2018-02-21

Initial development
