import { HydraAdmin, ResourceGuesser } from "@api-platform/admin";
import AccountBox from '@mui/icons-material/AccountBox';
import CurrencyYen from '@mui/icons-material/CurrencyYen';
import Receipt from '@mui/icons-material/Receipt';
import Store from '@mui/icons-material/Store';
import { i18nProvider } from './i18nProvider';
import { Dashboard } from './Dashboard';
import { authProvider } from './authProvider';
import { dataProvider } from './dataProvider';
import { AgentCreate, AgentEdit, AgentList } from "./guessers/agents";
import { OrderCreate, OrderEdit, OrderList } from './guessers/orders';
import { InvoiceCreate, InvoiceEdit, InvoiceList } from "./guessers/invoices";
import { UserCreate, UserEdit, UserList } from "./guessers/users";
import { AppBar, Layout, Login } from "react-admin";
import Typography from '@mui/material/Typography';
import Box from '@mui/material/Box';

const MyAppBar = (props:any) => (
  <AppBar sx={{"& .RaAppBar-title": {
          flex: 1,
          textOverflow: "ellipsis",
          whiteSpace: "nowrap",
          overflow: "hidden",
      },
    }}
    {...props}>
    <Typography
      variant="h6"
      color="inherit"
      sx={{
          flex: 1,
          textOverflow: 'ellipsis',
          whiteSpace: 'nowrap',
          overflow: 'hidden',
      }}
      id="react-admin-title"
    />
    <img src="logo.png" width="100"/>
  </AppBar>
);

const UlyLayout = (props: any) => <Layout {...props} appBar={MyAppBar} />;

const loginPage = () => (
  <Login style={{
      backgroundSize: 'contain'
    }}
    backgroundImage="./logo.png" />
);

export default () => (
  <HydraAdmin entrypoint="http://127.0.0.1:8000/api"
    authProvider={authProvider} 
    i18nProvider={i18nProvider}
    dataProvider={dataProvider}
    dashboard={Dashboard}
    title="Ulysses 代理店販売管理システム"
    layout={UlyLayout}
    loginPage={loginPage}
    >
    <ResourceGuesser name={"orders"} create={OrderCreate} edit={OrderEdit} list={OrderList} icon={CurrencyYen}/>
    <ResourceGuesser name={"invoices"} create={InvoiceCreate} edit={InvoiceEdit} list={InvoiceList} icon={Receipt}/>
    <ResourceGuesser name={"agents"} create={AgentCreate} edit={AgentEdit} list={AgentList} icon={Store}/>
    <ResourceGuesser name={"users"} create={UserCreate} edit={UserEdit} list={UserList} icon={AccountBox}/>
  </HydraAdmin>
);