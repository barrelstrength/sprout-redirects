# Changelog

## 1.2.1 - 2019-11-22

### Changed
- Updated barrelstrength/sprout-base-redirects requirement to v1.2.1

### Fixed
- Fixed support for database prefixes when finding URLs [#18][#18-base-redirects]

[#18-base-redirects] https://github.com/barrelstrength/craft-sprout-redirects/issues/18

## 1.2.0 - 2019-11-19

> {tip} This release is a recommended upgrade. Updates include improvements to the redirect workflow including how query strings are handled, managing excluded URLs from tracking, performance improvements around finding and cleaning up 404 Redirects, and several bug fixes include a potential security issue.

### Added
- Added 'Redirect Match Strategy' setting to control how query strings are handled when matching incoming redirects ([#6], [#16])
- Added 'Query String Strategy' setting to control if a query string is appended or removed when redirecting to a new URL ([#6], [#16])
- Added 'Clean Up Probability' setting to control the frequency that 404 Redirect cleanup tasks are triggered
- Added Last Remote IP Address, Last Referrer, Last User Agent, and Date Last Used fields to Redirect Elements ([#7], [#10])
- Added 'Track Remote IP' setting to enable/disable whether IP Address is stored in the database
- Added 'Excluded URL Patterns' setting to filter URL patterns you don't wish to log as 404 Redirects
- Added 'Add to Excluded URLs' Element Action to quickly add one or more 404 Redirects to the 'Excluded URL Patterns' setting

### Changed
- Improved performance when finding a match for an incoming URL
- Added the Redirect 'Data Last Used' field as default table attribute on the Element Index page ([#7])
- Updated Redirect 'RegEx' field to be named 'Match Strategy' with the strategies `Exact Match` and `Regular Expression`
- Improved validation when saving New URLs to avoid an edge case
- Updated barrelstrength/sprout-base-redirects requirement to v1.2.0
- Updated barrelstrength/sprout-base requirement to v5.0.8

### Fixed
- Fixed open redirect vulnerability (thanks to Liam Stein) ([#176sproutseo])
- Fixes bug where 404s could be matched before active redirects when matching regex URL patterns

[#6]: https://github.com/barrelstrength/craft-sprout-redirects/issues/6
[#7]: https://github.com/barrelstrength/craft-sprout-redirects/issues/7
[#10]: https://github.com/barrelstrength/craft-sprout-redirects/issues/10
[#16]: https://github.com/barrelstrength/craft-sprout-redirects/issues/16
[#176sproutseo]: https://github.com/barrelstrength/craft-sprout-seo/issues/176

## 1.1.2 - 2019-08-16

### Changed
- Updated barrelstrength/sprout-base requirement to v5.0.7

## 1.1.1 - 2019-08-14

### Changed
- Updated barrelstrength/sprout-base-redirects requirement to v1.1.2

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
- Updated barrelstrength/sprout-base-redirects requirement to v1.1.1

### Fixed 
- Fixed bug where 404 Redirect cleanup job was not working
- Fixed bug where Redirects could be double counted if SEO and Redirect plugins were both installed

## 1.0.2 - 2019-06-17

### Fixed
- Fixed invalid message category ([#11])

[#11]: https://github.com/barrelstrength/craft-sprout-redirects/issues/11

## 1.0.1 - 2019-04-28

### Changed
- Updated barrelstrength/sprout-base-redirects requirement to v1.0.10

### Fixed
- Improved Postgres support

## 1.0.0 - 2019-04-24

### Added 
- Initial release
