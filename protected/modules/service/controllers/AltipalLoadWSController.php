<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class AltipalLoadWSController extends Controller {

    public function actions() {
        return array(
            'quote' => array(
                'class' => 'CWebServiceAction',
            ),
        );
    }

    /*     * ***************************************************************************************** */

    /**
     * @param int
     * @param int
     * @param string
     * @param string
     * @param string
     * @return string  El mensaje del servicio
     * @soap
     */
    public function saveSendEmailProcess($ControllerId, $status, $ServerName, $Date, $Time) {
        return AltipalLoadWS::model()->setIndividualProcess($ControllerId, $status, $ServerName, $Date, $Time);
    }

    /**
     * @param string     
     * @param int
     * @param int
     * @param string
     * @param string
     * @return string  El mensaje del servicio
     * @soap
     */
    public function saveSendEmailProcessDetails($Method, $status, $ControllerId, $Date, $Time) {
        return AltipalLoadWS::model()->setIndividualProcessDetails($Method, $status, $ControllerId, $Date, $Time);
    }

    /**
     * @return string
     * @soap
     */
    public function QueryActiveAgencies() {
        return json_encode(AltipalLoadWS::model()->getActiveAgencies());
    }

    /**
     * @return string
     * @soap
     */
    public function QueryActiveSites() {
        return json_encode(AltipalLoadWS::model()->getActiveSites());
    }

    /**
     * @return string
     * @soap
     */
    public function SelectProcessingMethods() {
        return json_encode(AltipalLoadWS::model()->getProcessingMethods());
    }

    /**
     * @return string
     * @soap
     */
    public function SelectProcessingMethodsReRun() {
        return json_encode(AltipalLoadWS::model()->getProcessingMethodsReRun());
    }

    /**
     * @return string
     * @soap
     */
    public function QueryAllSalesZones() {
        return json_encode(AltipalLoadWS::model()->getAllSalesZones());
    }

    /**
     * @param string
     * @return string
     * @soap
     */
    public function SaveBudget($JsonBudget) {
        return AltipalLoadWS::model()->setBudget($JsonBudget);
    }

    /**
     * @param string
     * @return string
     * @soap
     */
    public function SaveMallaActivation($JsonMalla) {
        return AltipalLoadWS::model()->setMallaActivation($JsonMalla);
    }

    /**
     * @param string
     * @return string
     * @soap
     */
    public function saveGeneral($JsonMalla) {
        return AltipalLoadWS::model()->setGeneral($JsonMalla);
    }

    /**
     * @return string
     * @soap
     */
    public function SetActiveZonesStatusInCero() {
        return AltipalLoadWS::model()->setActiveZonesStatusInCero();
    }

    /**
     * @return string
     * @soap
     */
    public function UpdateGlobalSalesZone() {
        return AltipalLoadWS::model()->setUpdateGlobalSalesZone();
    }

    /**
     * @return string
     * @soap
     */
    public function UpdateGlobalSalesZoneCapacityCredit() {
        return AltipalLoadWS::model()->setUpdateGlobalSalesZoneCapacityCredit();
    }

    /**
     * @return string
     * @soap
     */
    public function UpdateGroupSalesStatus() {
        return AltipalLoadWS::model()->setUpdateGroupSalesStatus();
    }

    /**
     * @param string
     * @param string
     * @param string
     * @return string
     * @soap
     */
    public function UpdateCreditCapacityStatus($Zone, $Date, $Time) {
        return AltipalLoadWS::model()->setUpdateCreditCapacityStatus($Zone, $Date, $Time);
    }

    /**
     * @return string
     * @soap
     */
    public function UpdateInvoiceBalanceStatus() {
        return AltipalLoadWS::model()->setUpdateInvoiceBalanceStatus();
    }

    /**
     * @return string
     * @soap
     */
    public function UpdateInvoiceTransactionsStatus() {
        return AltipalLoadWS::model()->setUpdateInvoiceTransactionsStatus();
    }

    /**
     * @param string
     * @param string
     * @param string
     * @return string
     * @soap
     */
    public function UpdateDateInvoiceTransactionsStatus($Zone, $Date, $Time) {
        return AltipalLoadWS::model()->setUpdateDateInvoiceTransactionsStatus($Zone, $Date, $Time);
    }

    /**
     * @return string
     * @soap
     */
    public function UpdateOutstandingInvoiceStatus() {
        return AltipalLoadWS::model()->setUpdateOutstandingInvoiceStatus();
    }

    /**
     * @param string
     * @param string
     * @param string
     * @return string
     * @soap
     */
    public function UpdateDateOutstandingInvoiceStatus($Zone, $Date, $Time) {
        return AltipalLoadWS::model()->setUpdateDateOutstandingInvoiceStatus($Zone, $Date, $Time);
    }

    /**
     * @return string
     * @soap
     */
    public function UpdateSalesBudgetStatus() {
        return AltipalLoadWS::model()->setUpdateSalesBudgetStatus();
    }

    /**
     * @param string
     * @param string
     * @param string
     * @return string
     * @soap
     */
    public function UpdateDateSalesBudgetStatus($Zone, $Date, $Time) {
        return AltipalLoadWS::model()->setUpdateDateSalesBudgetStatus($Zone, $Date, $Time);
    }

    /**
     * @param string
     * @param string
     * @param string
     * @return string
     * @soap
     */
    public function UpdateDateInvoiceBalanceStatus($Zone, $Date, $Time) {
        return AltipalLoadWS::model()->setUpdateDateInvoiceBalanceStatus($Zone, $Date, $Time);
    }

    /**
     * @param int
     * @return string
     * @soap
     */
    public function UpdateMethodStatusToOne($id) {
        return AltipalLoadWS::model()->setUpdateMethodStatusToOne($id);
    }

    /**
     * @param int
     * @return string
     * @soap
     */
    public function UpdateMethodStatusToCero($id) {
        return AltipalLoadWS::model()->setUpdateMethodStatusToCero($id);
    }

    /**
     * @param string
     * @return string
     * @soap
     */
    public function QuerySalesZonesbyAgency($agencia) {
        return json_encode(AltipalLoadWS::model()->getQuerySalesZonesbyAgency($agencia));
    }

    /**
     * @param string
     * @param string
     * @param string
     * @param string
     * @param string
     * @param string
     * @param string
     * @param string
     * @param int
     * @param int
     * @return string
     * @soap
     */
    public function saveErrorGlobal($Message, $Controller, $Error, $Agency, $Date, $time, $Param, $ServerName, $ErrorType, $ControllerId) {
        return AltipalLoadWS::model()->setErrorGlobal($Message, $Controller, $Error, $Agency, $Date, $time, $Param, $ServerName, $ErrorType, $ControllerId);
    }

    /**
     * @param string
     * @param string
     * @param string
     * @return string
     * @soap
     */
    public function SaveSalesGroup($SalesGroup, $Agency, $SaleZone) {
        return AltipalLoadWS::model()->setSalesGroup($SalesGroup, $Agency, $SaleZone);
    }

    /**
     * @param string
     * @param string
     * @param string
     * @return string
     * @soap
     */
    public function SaveSalesZone($SalesZones, $Agency, $SaleZone) {
        return AltipalLoadWS::model()->setSalesZone($SalesZones, $Agency, $SaleZone);
    }

    /**
     * @param string
     * @param string
     * @param string
     * @return string
     * @soap
     */
    public function SaveCustomers($Customers, $Agency, $SaleZone) {
        return AltipalLoadWS::model()->setCustomers($Customers, $Agency, $SaleZone);
    }

    /**
     * @param string
     * @return string
     * @soap
     */
    public function SaveSalesZoneActives($SalesZones) {
        return AltipalLoadWS::model()->setSalesZoneActives($SalesZones);
    }

    /**
     * @param string
     * @return string
     * @soap
     */
    public function SaveSalesZoneInactives($SalesZones) {
        return AltipalLoadWS::model()->setSalesZoneInactives($SalesZones);
    }

    /**
     * @param string
     * @return string
     * @soap
     */
    public function SaveMerchandisers($Merchandisers) {
        return AltipalLoadWS::model()->setMerchandisers($Merchandisers);
    }

    /**
     * @param string
     * @return string
     * @soap
     */
    public function DeleteEmptyXmlSalesBudget($SalesZone) {
        return AltipalLoadWS::model()->setDeleteEmptyXmlSalesBudget($SalesZone);
    }

    /**
     * @param string
     * @param string
     * @return string
     * @soap
     */
    public function DeleteEmptyXmlInvoiceBalance($Agency, $SalesZone) {
        return AltipalLoadWS::model()->setDeleteEmptyXmlInvoiceBalance($Agency, $SalesZone);
    }

    /**
     * @param string
     * @param string
     * @return string
     * @soap
     */
    public function DeleteEmptyXmlOutstandingInvoice($Agency, $SalesZone) {
        return AltipalLoadWS::model()->setDeleteEmptyXmlOutstandingInvoice($Agency, $SalesZone);
    }

    /**
     * @param string
     * @param string
     * @return string
     * @soap
     */
    public function DeleteEmptyXmlInvoiceTransactions($Agency, $SalesZone) {
        return AltipalLoadWS::model()->setDeleteEmptyXmlInvoiceTransactions($Agency, $SalesZone);
    }

    /**
     * @param string
     * @return string
     * @soap
     */
    public function DeleteOtherAgenciesInzonaventaalmacen($Agency) {
        return AltipalLoadWS::model()->setDeleteOtherAgenciesInzonaventaalmacen($Agency);
    }

    /**
     * @param string
     * @return string
     * @soap
     */
    public function DeleteInactiveCustomers($Agency) {
        return AltipalLoadWS::model()->setDeleteInactiveCustomers($Agency);
    }

    /**
     * @param string
     * @return string
     * @soap
     */
    public function DeleteInactiveSalesGroup($Agency) {
        return AltipalLoadWS::model()->setDeleteInactiveSalesGroup($Agency);
    }

    /**
     * @return string
     * @soap
     */
    public function DeleteInactiveSalesGroupStatusCero() {
        return AltipalLoadWS::model()->setDeleteInactiveSalesGroupStatusCero();
    }

    /**
     * @param string
     * @return string
     * @soap
     */
    public function DeleteInactiveSalesZoneFromGlobal($Agency) {
        return AltipalLoadWS::model()->setDeleteInactiveSalesZoneFromGlobal($Agency);
    }

    /**
     * @return string
     * @soap
     */
    public function DeleteInactiveSalesZoneStatusCero() {
        return AltipalLoadWS::model()->setDeleteInactiveSalesZoneStatusCero();
    }

    /**
     * @return string
     * @soap
     */
    public function UpdateStatusForCompleteProcess() {
        return AltipalLoadWS::model()->setUpdateStatusForCompleteProcess();
    }

    /**
     * @param string
     * @return string
     * @soap
     */
    public function DeleteInactiveZonesCreditCapacity($Agency) {
        return AltipalLoadWS::model()->setDeleteInactiveZonesCreditCapacity($Agency);
    }

    /**
     * @param string
     * @return string
     * @soap
     */
    public function DeleteInactiveZonesInvoiceBalance($Agency) {
        return AltipalLoadWS::model()->setDeleteInactiveZonesInvoiceBalance($Agency);
    }

    /**
     * @param string
     * @return string
     * @soap
     */
    public function DeleteInactiveZonesInvoiceBalanceDetails($Agency) {
        return AltipalLoadWS::model()->setDeleteInactiveZonesInvoiceBalanceDetails($Agency);
    }

    /**
     * @param string
     * @return string
     * @soap
     */
    public function DeleteInactiveZonesInvoiceTransactions($Agency) {
        return AltipalLoadWS::model()->setDeleteInactiveZonesInvoiceTransactions($Agency);
    }

    /**
     * @param string
     * @return string
     * @soap
     */
    public function DeleteInactiveZonesOutstandingInvoice($Agency) {
        return AltipalLoadWS::model()->setDeleteInactiveZonesOutstandingInvoice($Agency);
    }

    /**
     * @param string
     * @return string
     * @soap
     */
    public function DeleteInactiveSitesConPreSalesInvent($Agency) {
        return AltipalLoadWS::model()->setDeleteInactiveSitesConPreSalesInvent($Agency);
    }

    /**
     * @param string
     * @return string
     * @soap
     */
    public function DeleteInactiveSitesInventLocationPreSales($Agency) {
        return AltipalLoadWS::model()->setDeleteInactiveSitesInventLocationPreSales($Agency);
    }

    /**
     * @param string
     * @return string
     * @soap
     */
    public function DeleteInactiveSitesInactiveVariants($Agency) {
        return AltipalLoadWS::model()->setDeleteInactiveSitesInactiveVariants($Agency);
    }

    /**
     * @return string
     * @soap
     */
    public function DeleteInactiveZonesSalesBudget() {
        return AltipalLoadWS::model()->setDeleteInactiveZonesSalesBudget();
    }

    /**
     * @return string
     * @soap
     */
    public function DeleteActiveZonesInCero() {
        return AltipalLoadWS::model()->setDeleteActiveZonesInCero();
    }

    /**
     * @return string
     * @soap
     */
    public function DeleteInactiveSalesZoneFromZonaVentas() {
        return AltipalLoadWS::model()->setDeleteInactiveSalesZoneFromZonaVentas();
    }

    /**
     * @param string
     * @param string
     * @param string
     * @return string
     * @soap
     */
    public function UpdateDate($Zone, $Date, $time) {
        return AltipalLoadWS::model()->setUpdateDate($Zone, $Date, $time);
    }

    /**
     * @param string
     * @return string
     * @soap
     */
    public function UpdateUpdateStatusSaleGroup($Agency) {
        return AltipalLoadWS::model()->setUpdateUpdateStatusSaleGroup($Agency);
    }

    /**
     * @param string
     * @return string
     * @soap
     */
    public function UpdateSaleGroupStatus($Group) {
        return AltipalLoadWS::model()->setUpdateSaleGroupStatus($Group);
    }

    /**
     * @param string
     * @return string
     * @soap
     */
    public function UpdateSiteConPreSalesInvent($Site) {
        return AltipalLoadWS::model()->setUpdateSiteConPreSalesInvent($Site);
    }

    /**
     * @param string
     * @return string
     * @soap
     */
    public function UpdateInactiveVariantsSite($Site) {
        return AltipalLoadWS::model()->setUpdateInactiveVariantsSite($Site);
    }

    /**
     * @param string
     * @return string
     * @soap
     */
    public function UpdateSalesZoneByAgencyToCero($Agency) {
        return AltipalLoadWS::model()->setUpdateSalesZoneByAgencyToCero($Agency);
    }

    /**
     * @param string
     * @return string
     * @soap
     */
    public function DeleteInactiveSalesGroupAgency($Agency) {
        return AltipalLoadWS::model()->setDeleteInactiveSalesGroupAgency($Agency);
    }

    /**
     * @param string
     * @return string
     * @soap
     */
    public function UpdateInventLocationPreSales($Site) {
        return AltipalLoadWS::model()->setUpdateInventLocationPreSales($Site);
    }

    /**
     * @param string
     * @param string
     * @param string
     * @param string
     * @return string
     * @soap
     */
    public function UpdateDatebyAgency($Zone, $Date, $time, $Agency) {
        return AltipalLoadWS::model()->setUpdateDatebyAgency($Zone, $Date, $time, $Agency);
    }

    /**
     * @param string
     * @return string
     * @soap
     */
    public function SaveLogisticZone($LogisticZone) {
        return AltipalLoadWS::model()->setLogisticZone($LogisticZone);
    }

    /**
     * @param string
     * @return string
     * @soap
     */
    public function SaveVehicles($Vehicles) {
        return AltipalLoadWS::model()->setVehicles($Vehicles);
    }

    /**
     * @param string
     * @return string
     * @soap
     */
    public function SaveProviderRestriction($ProviderRestriction) {
        return AltipalLoadWS::model()->setProviderRestriction($ProviderRestriction);
    }

    /**
     * @param string
     * @return string
     * @soap
     */
    public function SaveArticleHierarchy($ArticleHierarchy) {
        return AltipalLoadWS::model()->setArticleHierarchy($ArticleHierarchy);
    }

    /**
     * @param string
     * @return string
     * @soap
     */
    public function SaveConvertionUnits($ConvertionUnits) {
        return AltipalLoadWS::model()->setConvertionUnits($ConvertionUnits);
    }

    /**
     * @param string
     * @return string
     * @soap
     */
    public function SavePriceGroups($PriceGroups) {
        return AltipalLoadWS::model()->setPriceGroups($PriceGroups);
    }

    /**
     * @param string
     * @return string
     * @soap
     */
    public function SaveLineDiscountGroup($LineDiscountGroup) {
        return AltipalLoadWS::model()->setLineDiscountGroup($LineDiscountGroup);
    }

    /**
     * @param string
     * @return string
     * @soap
     */
    public function SaveMultiLineDiscountGroup($MultiLineDiscountGroup) {
        return AltipalLoadWS::model()->setMultiLineDiscountGroup($MultiLineDiscountGroup);
    }

    /**
     * @param string
     * @return string
     * @soap
     */
    public function SaveSites($sites) {
        return AltipalLoadWS::model()->setSites($sites);
    }

    /**
     * @param string
     * @return string
     * @soap
     */
    public function SaveStock($Stock) {
        return AltipalLoadWS::model()->setStock($Stock);
    }

    /**
     * @param string
     * @return string
     * @soap
     */
    public function SaveProvider($Provider) {
        return AltipalLoadWS::model()->setProvider($Provider);
    }

    /**
     * @param string
     * @return string
     * @soap
     */
    public function SaveSegmentation($Segmentation) {
        return AltipalLoadWS::model()->setSegmentation($Segmentation);
    }

    /**
     * @param string
     * @return string
     * @soap
     */
    public function SavePaymentConditions($Paymentconditions) {
        return AltipalLoadWS::model()->setPaymentConditions($Paymentconditions);
    }

    /**
     * @param string
     * @return string
     * @soap
     */
    public function SavePaymentTerms($PaymentTerms) {
        return AltipalLoadWS::model()->setPaymentTerms($PaymentTerms);
    }

    /**
     * @param string
     * @return string
     * @soap
     */
    public function SaveBankAccounts($BankAccounts) {
        return AltipalLoadWS::model()->setBankAccounts($BankAccounts);
    }

    /**
     * @param string
     * @return string
     * @soap
     */
    public function SaveCommercialHierarchy($CommercialHierarchy) {
        return AltipalLoadWS::model()->setCommercialHierarchy($CommercialHierarchy);
    }

    /**
     * @param string
     * @return string
     * @soap
     */
    public function SaveDocumentType($DocumentType) {
        return AltipalLoadWS::model()->setDocumentType($DocumentType);
    }

    /**
     * @param string
     * @return string
     * @soap
     */
    public function SaveSetOfOrders($SetOfOrders) {
        return AltipalLoadWS::model()->setSetOfOrders($SetOfOrders);
    }

    /**
     * @param string
     * @return string
     * @soap
     */
    public function SaveHomologationGroupTax($HomologationGroupTax) {
        return AltipalLoadWS::model()->setHomologationGroupTax($HomologationGroupTax);
    }

    /**
     * @param string
     * @return string
     * @soap
     */
    public function SaveCiiu($Ciiu) {
        return AltipalLoadWS::model()->setCiiu($Ciiu);
    }

    /**
     * @param string
     * @return string
     * @soap
     */
    public function SaveHomologationDocumentTypes($HomologationDocumentTypes) {
        return AltipalLoadWS::model()->setHomologationDocumentTypes($HomologationDocumentTypes);
    }

    /**
     * @param string
     * @return string
     * @soap
     */
    /* public function getZoneAgency($SalesZoneCode) {
      return AltipalLoadWS::model()->getZoneAgency($SalesZoneCode);
      } */

    /**
     * @return int
     * @soap
     */
    public function CountAmountofActiveAgenciesofGroups() {
        return AltipalLoadWS::model()->getAmountofActiveAgenciesofGroups();
    }

    /**
     * @return string
     * @soap
     */
    public function getActiveGroups() {
        return json_encode(AltipalLoadWS::model()->getActiveGroups());
    }

    /**
     * @param string
     * @return string
     * @soap
     */
    public function SaveLocalization($Localization) {
        return AltipalLoadWS::model()->setLocalization($Localization);
    }

    /**
     * @param string
     * @return string
     * @soap
     */
    public function SaveManagementReasonsCollection($ReasonsCollection) {
        return AltipalLoadWS::model()->setManagementReasonsCollection($ReasonsCollection);
    }

    /**
     * @param string
     * @return string
     * @soap
     */
    public function SaveReturnReasonsProvider($ReturnReasonsProvider) {
        return AltipalLoadWS::model()->setReturnReasonsProvider($ReturnReasonsProvider);
    }

    /**
     * @param string
     * @return string
     * @soap
     */
    public function SaveReturnReasonsProviderArticle($ReturnReasonsProviderArticle) {
        return AltipalLoadWS::model()->setReturnReasonsProviderArticle($ReturnReasonsProviderArticle);
    }

    /**
     * @param string
     * @return string
     * @soap
     */
    public function SaveReturnReasonsCustomers($ReturnReasonsCustomers) {
        return AltipalLoadWS::model()->setReturnReasonsCustomers($ReturnReasonsCustomers);
    }

    /**
     * @param string
     * @return string
     * @soap
     */
    public function SaveConceptsCreditNotes($ConceptsCreditNotes) {
        return AltipalLoadWS::model()->setConceptsCreditNotes($ConceptsCreditNotes);
    }

    /**
     * @param string
     * @return string
     * @soap
     */
    public function SaveBalanceReason($BalanceReason) {
        return AltipalLoadWS::model()->setBalanceReason($BalanceReason);
    }

    /**
     * @param string
     * @return string
     * @soap
     */
    public function SaveResolutions($Resolutions) {
        return AltipalLoadWS::model()->setResolutions($Resolutions);
    }

    /**
     * @param string
     * @return string
     * @soap
     */
    public function SaveCommercialDynamic($CommercialDynamic) {
        return AltipalLoadWS::model()->setCommercialDynamic($CommercialDynamic);
    }

    /**
     * @param string
     * @return string
     * @soap
     */
    public function SaveMaterialsList($MaterialsList) {
        return AltipalLoadWS::model()->setMaterialsList($MaterialsList);
    }

    /**
     * @param string
     * @return string
     * @soap
     */
    public function SaveSalePriceTradeAgreements($SalePriceTradeAgreements) {
        return AltipalLoadWS::model()->setSalePriceTradeAgreements($SalePriceTradeAgreements);
    }

    /**
     * @param string
     * @return string
     * @soap
     */
    public function SaveTradeAgreementsLineDiscount($TradeAgreementsLineDiscount) {
        return AltipalLoadWS::model()->setTradeAgreementsLineDiscount($TradeAgreementsLineDiscount);
    }

    /**
     * @param string
     * @return string
     * @soap
     */
    public function SaveTradeAgreementsMultiLineDiscount($TradeAgreementsMultiLineDiscount) {
        return AltipalLoadWS::model()->setTradeAgreementsMultiLineDiscount($TradeAgreementsMultiLineDiscount);
    }

    /**
     * @param string
     * @param string
     * @return string
     * @soap
     */
    public function SavePortfolio($Portfolio, $group) {
        return AltipalLoadWS::model()->setPortfolio($Portfolio, $group);
    }

    /**
     * @param string
     * @param string
     * @param string
     * @return string
     * @soap
     */
    public function SaveInventLocationPreSales($InventLocationPreSales, $Agency, $Site) {
        return AltipalLoadWS::model()->setInventLocationPreSales($InventLocationPreSales, $Agency, $Site);
    }

    /**
     * @param string
     * @param string
     * @param string
     * @return string
     * @soap
     */
    public function SaveConPreSalesInvent($ConPreSalesInvent, $Agency, $Site) {
        return AltipalLoadWS::model()->setConPreSalesInvent($ConPreSalesInvent, $Agency, $Site);
    }

    /**
     * @param string
     * @param string
     * @param string
     * @return string
     * @soap
     */
    public function SaveInactiveVariants($InactiveVariants, $Agency, $Site) {
        return AltipalLoadWS::model()->setInactiveVariants($InactiveVariants, $Agency, $Site);
    }

    /**
     * @param string
     * @param string
     * @param string
     * @return string
     * @soap
     */
    public function SaveCreditCapacity($CreditCapacity, $Agency, $SaleZone) {
        return AltipalLoadWS::model()->setCreditCapacity($CreditCapacity, $Agency, $SaleZone);
    }

    /**
     * @param string
     * @param string
     * @param string
     * @return string
     * @soap
     */
    public function SaveInvoiceBalance($InvoiceBalance, $Agency, $SaleZone) {
        return AltipalLoadWS::model()->setInvoiceBalance($InvoiceBalance, $Agency, $SaleZone);
    }

    /**
     * @param string
     * @param string
     * @param string
     * @return string
     * @soap
     */
    public function SaveInvoiceTransactions($InvoiceTransactions, $Agency, $SaleZone) {
        return AltipalLoadWS::model()->setInvoiceTransactions($InvoiceTransactions, $Agency, $SaleZone);
    }

    /**
     * @param string
     * @param string
     * @param string
     * @return string
     * @soap
     */
    public function SaveOutstandingInvoice($OutstandingInvoice, $Agency, $SaleZone) {
        return AltipalLoadWS::model()->setOutstandingInvoice($OutstandingInvoice, $Agency, $SaleZone);
    }

    /**
     * @param string
     * @param string
     * @param string
     * @return string
     * @soap
     */
    public function SaveSalesBudget($SalesBudget, $Agency, $SaleZone) {
        return AltipalLoadWS::model()->setSalesBudget($SalesBudget, $Agency, $SaleZone);
    }

    /**
     * @return string
     * @soap
     */
    public function DeleteEmptyHeaderAndDetail() {
        return AltipalLoadWS::model()->setDeleteEmptyHeaderAndDetail();
    }

    /**
     * @return string
     * @soap
     */
    public function ChangeHeaderStatusToOne() {
        return AltipalLoadWS::model()->setHeaderStatusToOne();
    }

    /**
     * @return string
     * @soap
     */
    public function ChangeProcessAltipalFromProcessActivity() {
        return AltipalLoadWS::model()->setChangeProcessAltipalFromProcessActivity();
    }

    /**
     * @param string $fechaInicial extructura   
     * @param string $fechaFinal extructura   
     * @param string $horaInicial extructura   
     * @param string $horaFinal extructura   
     * @return string  El mensaje del servicio
     * @soap
     */
    public function SendMail($fechaInicial, $fechaFinal, $horaInicial, $horaFinal) {
        $ActivityMail = AltipalLoadWS::model()->getEmailMessageActivity($fechaInicial, $fechaFinal, $horaInicial, $horaFinal);
        $AltipalMail = AltipalLoadWS::model()->getEmailMessageAltipal($fechaInicial, $fechaFinal, $horaInicial, $horaFinal);
        $SummaryMail = AltipalLoadWS::model()->getEmailMessageSummary($fechaInicial, $fechaFinal, $horaInicial, $horaFinal);
        return $ActivityMail . " - " . $AltipalMail . " - " . $SummaryMail;
    }

}
