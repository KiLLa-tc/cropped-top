import { CreateGuesser, FieldGuesser, InputGuesser } from "@api-platform/admin";
import LocalShipping from '@mui/icons-material/LocalShipping';
import Task from '@mui/icons-material/Task';
import { ArrayInput, AutocompleteInput, Button, Datagrid, Edit, List,
    NumberInput, ReferenceInput, SaveButton, SimpleForm, SimpleFormIterator, TextField, TextInput, useDataProvider, useEditContext } from "react-admin";

export const OrderCreate = (props: any) => (
    <CreateGuesser {...props}>
        {/* <InputGuesser source={"no"} /> */}
        <ReferenceInput source="site" reference="sites">
            <AutocompleteInput
                filterToQuery={searchText => ({ name: searchText })}
                optionText="name"
                label="resources.orders.fields.site"
            />
        </ReferenceInput>
        <InputGuesser source={"zipcode"} />
        <InputGuesser source={"address"} />
        <InputGuesser source={"customer"} />
        <InputGuesser source={"orderedAt"} />
        <InputGuesser source={"note"} />
        <ArrayInput source="orderDetails">
            <SimpleFormIterator inline>
                <TextInput source="merch" helperText={false} label="resources.orderDetails.fields.merch"/>
                <NumberInput source="price" helperText={false} label="resources.orderDetails.fields.price"/>
                <NumberInput source="amount" helperText={false} label="resources.orderDetails.fields.amount"/>
            </SimpleFormIterator>
        </ArrayInput>
    </CreateGuesser>
);

export const OrderList = () => (
    <List>
        <Datagrid rowClick="edit">
            <TextField source="id" />
            {/* <ArrayField source="orderDetails">
                <SingleFieldList><ChipField source="@type" /></SingleFieldList>
            </ArrayField> */}
            <TextField source="no" />
            {/* <TextField source="address" />
            <TextField source="zipcode" /> */}
            <TextField source="customer" />
            <TextField source="trackingNumber" />
        </Datagrid>
    </List>
);


export const OrderEdit = () => {
    const dataProvider = useDataProvider();
    const acceptable = function() {
        const ctx = useEditContext();
        return Boolean(ctx.record.acceptedAt);
    }
    /** 注文請け */
    const accept = (e: React.MouseEvent<HTMLButtonElement, MouseEvent>) => {
        e.preventDefault();
        const ctx = useEditContext();
        dataProvider.accept(ctx.data.userId, ctx.data.acceptedAt).then(() => {
            ctx.data.accepted = true;
        });
    };
    /** 配送 */
    const deliver = (e: React.MouseEvent<HTMLButtonElement, MouseEvent>) => {
        // todo: 配達処理
        e.preventDefault();
        const ctx = useEditContext();
        dataProvider.deliver(ctx.data.userId, ctx.data.acceptedAt).then(() => {
            // ctx.data.trackingNumber = true;
            // ctx.data.customer =
        });
    };
    return <Edit>
        <SimpleForm>
            <TextInput source="id" disabled/>
            <TextInput source="no" disabled/>
            <TextInput source="address" />
            <TextInput source="zipcode" />
            <TextInput source="customer" />
            <TextInput source="trackingNumber" />
            <TextInput source="note" />
            <ArrayInput source="orderDetails">
                <SimpleFormIterator inline>
                    <TextInput source="id" disabled/>
                    <TextInput source="merch" helperText={false} label="resources.orderDetails.fields.merch"/>
                    <NumberInput source="price" helperText={false} label="resources.orderDetails.fields.price"/>
                    <NumberInput source="amount" helperText={false} label="resources.orderDetails.fields.amount"/>
                </SimpleFormIterator>
            </ArrayInput>
            <fieldset>
                <legend>注文請け</legend>
                <InputGuesser source={"acceptedAt"}/><small> 未入力の場合現在時刻で自動入力されます。</small>
                <SaveButton type="button"
                    onClick={accept} label="注文請け"></SaveButton>
            </fieldset>
            <fieldset>
                <legend>配送</legend>
                <InputGuesser source={"dispatchedAt"} />
                <InputGuesser source={"trackingNumber"} />
                <SaveButton type="button"
                    onClick={deliver} label="発送"></SaveButton>
            </fieldset>
        </SimpleForm>
    </Edit>
};
// export const OrderEdit = (props: any) => (
//     <EditGuesser {...props}>
//         <InputGuesser source={"no"} />
//         <ReferenceInput source="site" reference="sites">
//             <AutocompleteInput
//                 filterToQuery={searchText => ({ name: searchText })}
//                 optionText="name"
//                 label="resources.orders.fields.site"
//             />
//         </ReferenceInput>
//         <InputGuesser source={"zipcode"} />
//         <InputGuesser source={"address"} />
//         <InputGuesser source={"customer"} />
//         <InputGuesser source={"note"} />
//         <InputGuesser source={"orderedAt"} />
//         <InputGuesser source={"acceptedAt"} />
//         <InputGuesser source={"dispatchedAt"} />
//         <InputGuesser source={"trackingNumber"} />
//         <ArrayInput source="orderDetails">
//             <SimpleFormIterator inline>
//             <TextInput source="merch" helperText={false} label="resources.orderDetails.fields.merch"/>
//                 <NumberInput source="price" helperText={false} label="resources.orderDetails.fields.price"/>
//                 <NumberInput source="amount" helperText={false} label="resources.orderDetails.fields.amount"/>
//             </SimpleFormIterator>
//         </ArrayInput>
//     </EditGuesser>
// );
// export const OrderList = (props: any) => (
//     <ListGuesser {...props}>
//         <FieldGuesser source={"orderedAt"} />
//         <FieldGuesser source={"acceptedAt"} />
//         <FieldGuesser source={"site"} />
//         <FieldGuesser source={"note"} />
//         <FieldGuesser source={"orderDetails"} />
//         <FieldGuesser source={"dispatchedAt"} />
//         <FieldGuesser source={"updatedAt"} />
//         <FieldGuesser source={"createdAt"} />
//         <FieldGuesser source={"no"} />
//         <FieldGuesser source={"address"} />
//         <FieldGuesser source={"zipcode"} />
//         <FieldGuesser source={"customer"} />
//         <FieldGuesser source={"trackingNumber"} />
//     </ListGuesser>
// );