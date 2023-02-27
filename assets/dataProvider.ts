import { fetchHydra, hydraDataProvider, HydraDataProviderFactoryParams } from '@api-platform/admin';
import { parseHydraDocumentation } from "@api-platform/api-doc-parser";
import { fetchUtils } from 'react-admin';
// import simpleRestProvider from 'ra-data-simple-rest';

// const fetchJson = (url: any, options: any = {}) => {
//     return fetchUtils.fetchJson(url, options);
// };
const hydra = hydraDataProvider({ 
    entrypoint: 'http://127.0.0.1:8000/api',
    httpClient: async (url, options) => {
        if(!localStorage.getItem('jwt'))
            return;
        const jwt = JSON.parse(localStorage.getItem('jwt')!);
        options!.user = {
            authenticated: true,
            token: `Bearer ${jwt.access_token}`
        };
        return await fetchHydra(url, options);
    },
    apiDocumentationParser: parseHydraDocumentation,
    useEmbedded: true,
    mercure: false
} as HydraDataProviderFactoryParams);

export const dataProvider = {
    ...hydra,
    /** 注文請け */
    acceptOrder: (orderId: number, acceptedAt: Date) => {
        return fetchUtils.fetchJson(`/orders/${orderId}/accept`, {
            method: 'PATCH',
            body: JSON.stringify({ acceptedAt })
        });
    },
    /** 注文確定 */
    fixOrder: (orderId: number, order: any) => {
        return fetchUtils.fetchJson(`/orders/${orderId}/fix`, {
            method: 'PUT',
            body: JSON.stringify({ order })
        });
    },
    /** 請求確定 */
    fixInvoice: (invoiceId: number, invoice: any) => {
        return fetchUtils.fetchJson(`/orders/${invoiceId}/fix`, {
            method: 'PUT',
            body: JSON.stringify({ invoice })
        });
    },
}