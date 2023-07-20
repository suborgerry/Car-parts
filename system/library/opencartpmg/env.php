#CONFIGURATION FILE

# The author of the plugin
AUTHOR=Decta

# need for naming log file, trnsactions, payment requests, etc
PLUGIN_ID=decta_payments_pmg

# name of plugin name. WITHOUT SPACES
PLUGIN_NAME=Decta Payments Gateway

# name for naming some additional packages, files, etc
PLUGIN_SHORT_NAME=decta_payments_gateway

# Shortname which will be avaliable customers near button "Pay" and as short description for module in "Modules"
PLUGIN_SHORTINFO=Pay with Visa / MasterCard
PLUGIN_SHORTINFO_RU=Оплата Visa / MasterСard
PLUGIN_SHORTINFO_LV=Maksājiet ar Visa / MasterCard

#notification about DMS transaction
MESSAGE_DMS=The payment is successful. Payment status is "Hold"! Please capture/void payment in your payment gateway personal %cabinet%!

#notification about success transaction
MESSAGE_SUCCESS_TRANSACTION=Payment successful!

#module version
PAYMENTS_MODULE_VERSION=v3.0

#gate for payment which will be used
GATE=https://gate.decta.com

#version on API for make payment via GATE
PAYMENT_API_VERSION=v0.6

#MINIMAL PARAMETERS FOR PLUGIN
OPENCART_VERSION_MIN=2.3.0 # minimal OpenCart version
OPENCART_VERSION_MAX=3.5.0 # minimal OpenCart version
PHP_VERSION_MIN=5.6
#END CONFIG
