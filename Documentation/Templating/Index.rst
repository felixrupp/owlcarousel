.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


Templating
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Using the following Page TsConfig the editor can select the layouts in the news plugin: ::

    tx_owlcarousel.templateLayouts {
        1 = A custom layout
        99 = LLL:fileadmin/somelocallang/locallang.xlf:someTranslation
    }

You can use any number to identify your layout and any label to describe it.

Now it is possible to use a condition in the template to change the layouts, and e.g. load a different partial: ::

    <f:if condition="{settings.templateLayout} == 99">
        <f:then>
            Something
        </f:then>
        <f:else>
            Something else
        </f:else>
    </f:if>