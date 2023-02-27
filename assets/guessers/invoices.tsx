import { CreateGuesser, FieldGuesser, InputGuesser } from "@api-platform/admin";
import { ArrayInput, AutocompleteInput, Datagrid, DateField, DateInput, Edit, EditGuesser, List, ListGuesser, NumberInput, ReferenceInput, ReferenceManyField, ShowGuesser, SimpleForm, SimpleFormIterator, TextField, TextInput } from "react-admin";

export const InvoiceCreate = (props: any) => (
    <CreateGuesser {...props}>
        {/* <InputGuesser source={"no"} /> */}
        <InputGuesser source={"title"} />
        <ReferenceInput source="site" reference="sites">
            <AutocompleteInput
                filterToQuery={searchText => ({ name: searchText })}
                optionText="name"
                label="resources.invoices.fields.site"
            />
        </ReferenceInput>
        <ArrayInput source="invoiceDetails">
            <SimpleFormIterator inline>
                <TextInput source="merch" helperText={false} label="resources.invoiceDetails.fields.merch"/>
                <NumberInput source="price" helperText={false} label="resources.invoiceDetails.fields.price"/>
                <NumberInput source="amount" helperText={false} label="resources.invoiceDetails.fields.amount"/>
            </SimpleFormIterator>
        </ArrayInput>
    </CreateGuesser>
);

export const InvoiceEdit = () => (
    <Edit>
        <SimpleForm>
            <TextInput source="id" disabled/>
            {/* <DateInput source="updatedAt" />
            <DateInput source="createdAt" /> */}
            <TextInput source="no" disabled/>
            <TextInput source="title" />
            <ReferenceInput source="site" reference="sites">
                <AutocompleteInput
                    filterToQuery={searchText => ({ name: searchText })}
                    optionText="name"
                    label="resources.invoices.fields.site"
                />
            </ReferenceInput>
            <ArrayInput source="invoiceDetails">
                <SimpleFormIterator inline>
                    <TextInput source="id" contentEditable={false} disabled/>
                    <TextInput source="merch" helperText={false} label="resources.invoiceDetails.fields.merch"/>
                    <NumberInput source="price" helperText={false} label="resources.invoiceDetails.fields.price"/>
                    <NumberInput source="amount" helperText={false} label="resources.invoiceDetails.fields.amount"/>
                    {/* <DateInput source="updatedAt" />
                    <DateInput source="createdAt" /> */}
                </SimpleFormIterator>
            </ArrayInput>
            <hr></hr>
            <DateInput source="publishedAt" disabled/><small>請求確定で自動入力されます</small>
        </SimpleForm>
    </Edit>
);
export const InvoiceList = () => (
    <List>
        <Datagrid rowClick="edit">
            <TextField source="id" />
            <TextField source="no" />
            <TextField source="title" />
            {/* <ArrayField source="invoiceDetails">
                <SingleFieldList>
                    <ChipField source="@type" />
                </SingleFieldList>
            </ArrayField> */}
            <DateField source="publishedAt" />
        </Datagrid>
    </List>
);

// export const InvoiceEdit = (props: any) => (
//     <EditGuesser {...props}>
//         <InputGuesser source={"no"} />
//         <InputGuesser source={"title"} />
//         <InputGuesser source={"publishedAt"} />
//         <ReferenceInput source="site" reference="sites">
//             <AutocompleteInput
//                 filterToQuery={searchText => ({ name: searchText })}
//                 optionText="name"
//                 label="resources.invoices.fields.site"
//             />
//         </ReferenceInput>
//         <ArrayInput source="invoiceDetails">
//             <SimpleFormIterator inline>
//                 <TextInput source="merch" helperText={false} label="resources.invoiceDetails.fields.merch"/>
//                 <NumberInput source="price" helperText={false} label="resources.invoiceDetails.fields.price"/>
//                 <NumberInput source="amount" helperText={false} label="resources.invoiceDetails.fields.amount"/>
//             </SimpleFormIterator>
//         </ArrayInput>
//     </EditGuesser>
// );

// export const InvoiceShow = (props: any) => (
//     <ShowGuesser {...props}>
//       <FieldGuesser source={"no"} />
//       <FieldGuesser source={"title"} />
//       <FieldGuesser source={"invoiceDetails"} />
//       <FieldGuesser source={"publishedAt"} />
//       <FieldGuesser source={"updatedAt"} />
//       <FieldGuesser source={"createdAt"} />
//     </ShowGuesser>
// );
// export const InvoiceList = (props: any) => (
//     <ListGuesser {...props} filter={["site"]}>
//         {/* <FieldGuesser source={"updatedAt"} />
//         <FieldGuesser source={"createdAt"} /> */}
//         <FieldGuesser source={"no"} />
//         <FieldGuesser source={"title"} />
//         {/* <FieldGuesser source={"invoiceDetails"} /> */}
//         <FieldGuesser source={"site"} />
//         <FieldGuesser source={"publishedAt"} />
//     </ListGuesser>
// );