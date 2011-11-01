This is supposed to just be some really trivial tools to assist people getting started learning magento. The scripts
are just being created in class as we are doing the Magento Developer Fundamentals as a way to solidy knowledge.

The may help others. I have done them using Zend Framework Tool as I guess there is a strong relationship between
Zend Framework and Magento.

# Using the tools

Type `zf` to see the MagentoRealisation and MagentoModules commands.

## MagentoRealisation

This assists telling you which the path, such as `catalog/product` maps to a class, and tells you where it exists. This works for Models, Resource Models, Blocks, etc.

    $ zf block magento-realise
    ========================= Magento Class Realisation ==========================
    
    Block Class Realisation


    Enter the path to resolve (e.g. core/template):
    zf> catalog/product
    Magento mapped this to:
    "Foo_Bar_Block_Product"
    Location:
    app/code/local/Foo/Bar/Block/Product.php


    array(1) {
      ["type"] => string(15) "catalog/product"
    }


# Install

Download and put the commands in the zf include path, like `/usr/share/php/libzend-framework-php`

You will need to be able to install the following:
- ZF


## Install ZF on Ubuntu

We are doing the class on ubuntu, so...

### Install zf tool

You will need to be able to run `zf` from the command line.

Install the ZF framework bin commands

    sudo apt-get install zend-framework-bin

### Load some commands

If you haven't got a .zf.ini, create it using the following

    zf create config

Add the following to your php.ini

    basicloader.classes.1 = "FlintLabs_Magento_Commands_MagentoRealise"
    basicloader.classes.1 = "FlintLabs_Magento_Commands_MagentoModules"
