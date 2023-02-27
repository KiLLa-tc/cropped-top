import { CreateGuesser, InputGuesser } from '@api-platform/admin';
import { Datagrid, Edit, EditGuesser, EmailField, List, SimpleForm, TextField, TextInput } from 'react-admin';

export const UserList = () => (
    <List>
        <Datagrid rowClick="edit">
            <TextField source="id" />
            <TextField source="username" />
            <EmailField source="email" />
        </Datagrid>
    </List>
);
export const UserEdit = () => (
    <Edit>
        <SimpleForm>
            <TextInput source="id" />
            <TextInput source="username" />
            <TextInput source="email" />
        </SimpleForm>
    </Edit>
);
export const UserCreate = (props: any) => (
    <CreateGuesser {...props}>
        <InputGuesser source="id" />
        <InputGuesser source="username" />
        <InputGuesser source="email" />
    </CreateGuesser>
);
// export const UserEdit = (props:any) => (
//     <EditGuesser {...props}>
//     </EditGuesser>
// );