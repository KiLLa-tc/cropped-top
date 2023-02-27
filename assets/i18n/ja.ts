import { TranslationMessages } from 'react-admin';
import lang from '@bicstone/ra-language-japanese';

const ja = {
    ...lang,
    resources: {
        agents: {
            name: '代理店',
            fields: {
                name: '代理店名',
                zipcode: '郵便番号',
                address: '住所',
                phone: '電話番号',
                pic: '担当者',
                user: 'ユーザアカウント',
                sites: 'サイト',
                createdAt: '作成日時',
                updatedAt: '更新日時',
            },
        },
        sites: {
            name: 'サイト',
            fields: {
                name: 'サイト名',
                url: 'URL',
                createdAt: '作成日時',
                updatedAt: '更新日時',
            }
        },
        orders: {
            name: '注文',
            fields: {
                orderedAt: '注文日',
                dispatchedAt: '発送日時',
                acceptedAt: '注文請日時',
                zipcode: '郵便番号',
                address: '住所',
                customer: '購入者',
                shipping: '配送業者',
                trackingNumber: '追跡番号',
                site: 'サイト',
                note: '備考',
                title: 'タイトル',
                orderDetails: '詳細',
                createdAt: '作成日時',
                updatedAt: '更新日時',
            }
        },
        orderDetails: {
            name: '注文詳細',
            fields: {
                merch: '商品名',
                price: '単価',
                amount: '数量',
                createdAt: '作成日時',
                updatedAt: '更新日時',
            }
        },
        invoices: {
            name: '請求',
            invoiceDetails: '詳細',
            fields: {
                deliveredAt: '発送日',
                publishedAt: '発行日',
                invoiceDetails: '詳細',
                site: 'サイト',
                title: 'タイトル',
                createdAt: '作成日時',
                updatedAt: '更新日時',
            }
        },
        invoiceDetails: {
            name: '請求詳細',
            fields: {
                merch: '商品名',
                price: '単価',
                amount: '数量',
                createdAt: '作成日時',
                updatedAt: '更新日時',
            }
        },
        users: {
            name: 'アカウント',
            fields: {
                username: 'ユーザ名',
                roles: '権限',
                password: 'パスワード',
                createdAt: '作成日時',
                updatedAt: '更新日時',
            }
        }
    }
};
export default ja;