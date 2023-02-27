import * as df from "date-fns";
import jwt_decode from "jwt-decode";
// import { fetchUtils } from "react-admin";
// import { stringify } from "query-string";

const apiUrl = 'http://127.0.0.1:8000';
// const httpClient = fetchUtils.fetchJson;

export const authProvider = {
  login: ({ username, password }: any) =>  {
    const request = new Request(`${apiUrl}/authentication_token`, {
        method: 'POST',
        body: JSON.stringify({ username, password }),
        headers: new Headers({ 'Content-Type': 'application/json' }),
    });
    return fetch(request)
        .then(response => {
            if (response.status < 200 || response.status >= 300) {
                throw new Error(response.statusText);
            }
            return response.json();
        })
        .then(({ token }) => {
          const jwt = jwt_decode(token) as any;
          localStorage.setItem('jwt', JSON.stringify({
            access_token: token,
            roles: jwt.roles,
            expires_in: df.fromUnixTime(jwt.exp),
            username: jwt.username,
            email: jwt.email,
          }));
        })
        .catch(() => {
            throw new Error('Network error')
        });
    },
    // called when the user clicks on the logout button
    logout: () => {
      localStorage.removeItem("jwt");
      return Promise.resolve();
    },
    // called when the API returns an error
    checkError: ({ status }: any) => {
      if (status === 401 || status === 403) {
        localStorage.removeItem("jwt");
        return Promise.reject();
      }
      return Promise.resolve();
    },
    // called when the user navigates to a new location, to check for authentication
    checkAuth: () => {
      if(!localStorage.getItem("jwt"))
        return Promise.reject();
      const jwt = JSON.parse(localStorage.getItem("jwt")!);
      if(df.parseJSON(jwt.expires_in) < new Date())
        return Promise.reject();
      return Promise.resolve();
    },
    // called when the user navigates to a new location, to check for permissions / roles
    getPermissions: () => {
      const json = localStorage.getItem("jwt");
      if(!json)
        return Promise.resolve([]);
      const p = JSON.parse(json);
      return Promise.resolve(p.roles);
    },
    // get the user's profile
    getIdentity: () => {
      const json = localStorage.getItem("jwt");
      if(!json)
        return Promise.resolve({});
      const u = JSON.parse(json);
      return Promise.resolve(u);
    },
  };