import { Account } from "./consts";
import typeText from "./typeText";
import { Selector } from "testcafe";

export default async function login(
  t: TestController,
  account: Account
) {
  await t.navigateTo(`http://127.0.0.1/News_website/?module=auth&action=login`);
  await typeText(t, Selector('[name="email"]'), account.email);
  await typeText(t, Selector('[name="password"]'), account.password);
  await t.click(Selector('.signInButton'));
}
