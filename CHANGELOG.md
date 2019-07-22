# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [2.2.3]
### Changed
- Removed `LibraryEventBookDownloadedCommand`

## [2.2.2]
### Changed
- Changed package name to `ridi/library`.

## [2.2.1]
### Changed
- Changed package name to `ridi/library-command`.

## [2.2.0]
***Preparing for opening source***

### Added
- Wrote default values of library options in `RequestOptions` PHPDoc.
- Added `MIT LICENSE` specifying the copyright is on `RIDI Corporation`
- Added `CHANGELOG.md`.

### Changed
- Rewrote some sections of `composer.json` and `README.md`.
- Changed package name to `ridibooks/library-command`.

## [2.1.0]
### Added
- Added `RequestOptions` constant class
- Added `RequestOptions::RESPONSE_TYPE_B_IDS`, so that response type can be determined at requesting time
- Added `LibraryAction` and `LibraryItem` interfaces
- `LibraryItemFull` and `LibraryItemUpdateExpiration` can be constructed using `LibraryItem`
- Added `LibraryActionService`, which converts `LibraryAction` into `UserCommand`
- `Client` supports calling API with `LibraryAction`
- `UserCommand->setResponseTypeBids` returns `$this`

### Changed
- `Client` methods throw `RequestException`
- `PromiseInterface` returned by `Client` is rejected with `RequestException`
- Improved synchronous API call internally.

### Deprecated
- Deprecated `JWT_EXPIRATION_TIME_OPTION`. Use `RequestOptions::JWT_EXPIRATION_TIME` instead.


## [2.0.1]
### Added
- Allow `firebase/php-jwt` version 4.

## [2.0.0]
### Added
- `Client` methods(`sendCommandAsync`, `sendCommand`) support injecting options
- JWT private key must be passed to `Client` constructor, and `Client` manage JWT authorization by itself.

### Changed
- Renamed all `Payload Command` classes in accordance with model names of library API specification.
- `priority` paremeter of `LibraryEventBookDownloadedCommand` became required, which was optional.

### Removed
- Removed every `Payload`. Refactored to `Command`.

## [1.3.0]
### Added
- `Client` supports `Payload`, not only `BasePayload`.
- Added `RevisionService` which creates revision from `\DateTime`.
- Added `LibraryEventBookDownloadedCommand` for `PUT /commands/items/events/book-downloaded/`.

### Deprecated
- Deprecated `getType` function of `CommandPayload`.
- Deprecated `DeleteCommandPayload->getBIds`.

## [1.2.1]
### Fixed
- Corrected URI which `UpdateExpirationCommandPayload` references.

## [1.2.0]
### Added
- Added `Ridibooks\Store\Library\AccountCommandApiClient\Payload\Payload`.
- Added constant classes for job status and command type.
- Added `UpdateExpirationCommandPayload`.

### Deprecated
- Deprecated `Book`.
- Deprecated `Ridibooks\Store\Library\BasePayload`. Use `Ridibooks\Store\Library\AccountCommandApiClient\Payload\Payload` instead.

## [1.1.2]
### Changed
- Added `response_type` to Command.

## [1.1.1]
### Changed
- Replaced `DATE_ATOM` with RFC.

## [1.1.0]
### Changed
- Removed `type` and `user_idx` from URL.
- Determined `Update` or `Delete` type by checking HTTP Method.
- Removed `command_type` from `request_body`.

## [1.0.0]
### Changed
- Changed Library API endpoint.

## [0.0.3]
### Added
- Abstracted logic creating payloads.

## [0.0.2]
### Changed
- Used `update` type instead of `insert` type.

## [0.0.1]
### Added
- Initialized library.
