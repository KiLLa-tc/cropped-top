import { CreateGuesser, FieldGuesser, InputGuesser } from "@api-platform/admin";
import { ArrayInput, AutocompleteInput, Datagrid, Edit, EmailField, List, ReferenceInput, SimpleForm, SimpleFormIterator, TextField, TextInput } from "react-admin";

export const AgentCreate = (props: any) => (
    <CreateGuesser {...props}>
        <InputGuesser source={"name"} />
        <InputGuesser source={"pic"} />
        <InputGuesser source={"email"} />
        <InputGuesser source={"phone"} />
        <InputGuesser source={"zipcode"} />
        <InputGuesser source={"address"} />
        <ReferenceInput
            source="user" reference="users">
            <AutocompleteInput
                filterToQuery={searchText => ({ email: searchText })}
                optionText="email"
                label="resources.agents.fields.user"
            />
        </ReferenceInput>
        <ArrayInput source="sites">
            <SimpleFormIterator inline>
                <TextInput source="name" helperText={false} label="resources.sites.fields.name"/>
                <TextInput source="url" helperText={false}  label="resources.sites.fields.url"/>
            </SimpleFormIterator>
        </ArrayInput>
    </CreateGuesser>
);
export const AgentList = () => (
    <List>
        <Datagrid rowClick="edit">
            <TextField source="id" />
            <TextField source="name" />
            <TextField source="pic" />
            <EmailField source="email" />
            <TextField source="phone" />
            {/* <TextField source="zipcode" />
            <TextField source="address" /> */}
            <TextField source="user" />
        </Datagrid>
    </List>
);

export const AgentEdit = () => (
    <Edit>
        <SimpleForm>
            <TextInput source="id" />
            <TextInput source="name" />
            <TextInput source="pic" />
            <TextInput source="email" />
            <TextInput source="phone" />
            <TextInput source="zipcode" />
            <TextInput source="address" />
            <TextInput source="user" />
            <ArrayInput source="sites">
                <SimpleFormIterator inline>
                    <TextInput source="id" />
                    <TextInput source="name" helperText={false} label="resources.sites.fields.name"/>
                    <TextInput source="url" helperText={false}  label="resources.sites.fields.url"/>
                </SimpleFormIterator>
            </ArrayInput>
        </SimpleForm>
    </Edit>
);
// export const AgentEdit = (props: any) => (
//     <EditGuesser {...props}>
//         <InputGuesser source={"name"} />
//         <InputGuesser source={"pic"} />
//         <InputGuesser source={"email"} />
//         <InputGuesser source={"phone"} />
//         <InputGuesser source={"zipcode"} />
//         <InputGuesser source={"address"} />
//         <ReferenceInput
//             source="user" reference="users">
//             <AutocompleteInput
//                 filterToQuery={searchText => ({ email: searchText })}
//                 format={v => v['@id'] || v}
//                 optionText="email"
//                 label="resources.agents.fields.user"
//             />
//         </ReferenceInput>
//         <ArrayInput source="sites">
//             <SimpleFormIterator inline>
//                 <TextInput source="name" helperText={false} />
//                 <TextInput source="url" helperText={false} />
//             </SimpleFormIterator>
//         </ArrayInput>
//     </EditGuesser>
// );

// export const AgentList = (props: any) => (
//     <ListGuesser {...props}>
//         <FieldGuesser source={"name"} />
//         <FieldGuesser source={"pic"} />
//         <FieldGuesser source={"email"} />
//         <FieldGuesser source={"phone"} />
//         <FieldGuesser source={"zipcode"} />
//         <FieldGuesser source={"address"} />
//         {/* <FieldGuesser source={"updatedAt"} /> */}
//         {/* <FieldGuesser source={"user"} /> */}
//         {/* <FieldGuesser source={"Sites"} /> */}
//         {/* <FieldGuesser source={"createdAt"} /> */}
//     </ListGuesser>
// );