# Changelog

## 1.1.2 - 2019-08-16

### Changed
- Updated barrelstrength/sprout-base requirement v5.0.7

## 1.1.1 - 2019-08-14

### Changed
- Updated barrelstrength/sprout-base-redirects requirement v1.1.2

### Fixed
- Fixed js console warning when Craft is only configured with a single Site
- Fixed bug where incorrect return type hint was used

## 1.1.0 - 2019-08-06

### Added
- Added ability to sort Redirects by Count
- Added hard delete support for Redirect Elements

### Changed
- Sprout Redirects Lite now is full featured with a limit of 3 Redirect Rules
- Updated 'All Redirects' Element index listing to only show 301 and 302 Redirects, and exclude 404 Redirects
- Improved performance of Delete 404 task during large cleanup tasks 
- Updated barrelstrength/sprout-base-redirects requirement v1.1.1

### Fixed 
- Fixed bug where 404 Redirect cleanup job was not working
- Fixed bug where Redirects could be double counted if SEO and Redirect plugins were both installed

## 1.0.2 - 2019-06-17

### Fixed
- Fixed invalid message category ([#11])

[#11]: https://github.com/barrelstrength/craft-sprout-redirects/issues/11

## 1.0.1 - 2019-04-28

### Changed
- Updated barrelstrength/sprout-base-redirects requirement v1.0.10

### Fixed
- Improved Postgres support

## 1.0.0 - 2019-04-24

### Added 
- Initial release
